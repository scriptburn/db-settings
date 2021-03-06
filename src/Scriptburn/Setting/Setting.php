<?php
namespace ScriptBurn\Setting;

class Setting
{
	protected $pdo, $tableName;

	public function __construct($pdo, $tableName = "scb_settings")
	{
		$this->tableName = $tableName ? $tableName : 'scb_settings';
		if (get_class($pdo) == 'Illuminate\Database\DatabaseManager')
		{
			$this->pdo = \DB::connection()->getPdo();
		}
		else
		{
			$this->pdo = $pdo;
			$this->setup();
		}
	}
	private function setup()
	{
		try
		{
			$table_exists = function ($table)
			{
				try
				{
					$result = $this->pdo->query("select 1 from $table limit 1")->execute();

					return true;
				}
				catch (\Exception $e)
				{
					return false;
				}
			};
			$create_table = function ($table)
			{
				$table = is_array($table) ? $table : [$table];
				foreach ($table as $tbl)
				{
					$this->pdo->query($tbl);
				}
			};
			$settings_table[] = "
CREATE TABLE `{$this->tableName}` (
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` datetime  NULL,
  `updated_at` datetime    NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
			$settings_table[] = "ALTER TABLE `{$this->tableName}`
  ADD PRIMARY KEY (`name`);";
			if (!$table_exists($this->tableName))
			{
				$create_table($settings_table);
			}
		}
		catch (\Exception $e)
		{
			throw new \Exception("Unable to settings module:".$e->getMessage());
		}
	}
	public function get($name, $default = null)
	{
		$names = is_array($name) ? $name : [$name];

		$namesStr = str_repeat("?,", count($names) - 1)."?";
		$stmt = $this->pdo->prepare("select * from {$this->tableName}  where name in($namesStr)");
		$stmt->execute($names);

		$rows = [];
		while ($data = $stmt->fetch())
		{
			if (is_null($data['expires_at']))
			{
				$rows[$data['name']] = $data['value'];
			}
			elseif (time() >= strtotime($data['expires_at']))
			{
				$deleteStatement = $this->pdo->prepare("delete   from {$this->tableName}  where name =?");
				$deleteStatement->bindValue(1, $name);
				$affectedRows = $deleteStatement->execute();

				$rows[$data['name']] = $default;
			}
			else
			{
				$rows[$data['name']] = $data['value'];
			}
		}
		foreach ($names as $name)
		{
			if (!isset($rows[$name]))
			{
				$rows[$name] = $default;
			}
		}

		if (count($names) > 1)
		{
			return $rows;
		}
		else
		{
			$rows = array_values($rows);

			return $rows[0];
		}
	}
	public function set($name, $value = null, $expires = null)
	{
		$rows = is_array($name) ? $name : [$name => $value];
		foreach ($rows as $name => $value)
		{
			if (is_null($value))
			{
				$insertStatement = $this->pdo->prepare("delete from {$this->tableName}  where name=?");
                $insertStatement->execute(array($name));
			}
			else
			{
				$expires = is_null($expires) ? $expires : date("Y-m-d H:i:s", time() + $expires);
				$insertStatement = $this->pdo->prepare("INSERT INTO {$this->tableName} (`name`, `value`, `created_at`, `updated_at`, `expires_at`)
                                            VALUES(?, ?, NOW(),NOW(),?) on duplicate key update `value`=?,`updated_at`=NOW()");
				$insertStatement->execute(array($name, $value, $expires, $value));
			}
		}

		return $rows;
	}
	public function delete($name)
	{
		$this->set($name,  null);
	}
}
