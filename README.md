> 安装包附在文末

- 安装后会自动创建表：
    自定义配置表（admin_jef_dcat_config）、自定义配置分组表（admin_jef_dcat_config_group）
- 自动写入部分默认数据（安装后可手动删除和修改）


![DcatAdmin 自定义配置扩展](https://cdn.learnku.com/uploads/images/202212/03/65326/dCKT2UywfO.png!large)

- 配置分组的配置总是在其他分组配置末尾处进行配置

![DcatAdmin 自定义配置扩展](https://cdn.learnku.com/uploads/images/202212/03/65326/s2azgOfHTh.png!large)

- 新增和删除配置操作也很简单，看到上面两个按钮了没

![DcatAdmin 自定义配置扩展](https://cdn.learnku.com/uploads/images/202212/03/65326/zUg8VP7G7H.png!large)

![DcatAdmin 自定义配置扩展](https://cdn.learnku.com/uploads/images/202212/03/65326/Th410h2c7y.png!large)

- 若要获取配置中的参数，已提供以下方法

```php
use Dcat\Admin\Jef\DcatConfig\Models\MyConfig;

//获取指定配置内容
MyConfig::getConfigContent($config_name);

//获取指定配置详情
MyConfig::getConfig($config_name);

//获取指定分组中的所有配置详情
MyConfig::getGroupConfigs($config_group_key);
```
