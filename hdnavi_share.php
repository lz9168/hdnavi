<?PHP
#本程序仅仅是个业务逻辑的说明。
#本程序无法直接运行。请勿用于生成环境。
#如需技术支持，请发送 email to: Lz9168@163.com
class DBOBJ_PDO_SQLITE {
	function connect($dbfile){/*连接数据库*/}
	function query($sql){/*执行sql*/}
 	function fetch_array($result){/*返回结果*/}
}

function create_group($devid, $name, $iconid, $group, $group_pwd){$DB->query("INSERT INTO group(devid,code,password) VALUES('$devid','$group_code','$group_password')");$DB->query("INSERT INTO user(devid,group_code,name,iconid) VALUES('$devid','$group_code','$name',$iconid)");return "OK:1:$group_code:$group_password";}
function join_group($devid, $name, $iconid, $group_code){$DB->query("INSERT INTO user(devid,group_code,name,iconid) VALUES('$devid','$group_code','$name',$iconid)");return "OK:2:$group_code:";}
function del_group($devid, $name, $group_code, $group_pwd){$DB->query("DELETE FROM user WHERE devid='$devid' AND group_code='$group_code'");return "OK:3::";}
function update_gps($devid, $group_code, $lat, $lng, $alt, $time){$DB->query("UPDATE user SET lat='".$lat."',lng='".$lng."',alt='".$alt."',gtime='". date("Y-m-d H:i:s", time()) ."'"." WHERE devid='$devid' AND group_code='$group_code'");}
function get_gps($devid, $group_code){$DB->query("SELECT name,iconid,lat,lng,alt FROM user WHERE devid<>'$devid' AND group_code='$group_code'");$all="Data";while ($r = $DB->fetch_array($query) ){if (!empty($all)) $all .= ";";$all .= $r['name'].",".$r['iconid'].",".$r['lat'].",".$r['lng'].",".$r['alt'];}return $all;}

$G_aid = isset($_GET['aid']) ? intval($_GET['aid']) : 0;
$G_did = isset($_GET['did']) ? ($_GET['did']) : '';
$G_hp  = isset($_GET['hp']) ? ($_GET['hp']) : '';
$G_name= isset($_GET['name']) ? ($_GET['name']) : '';
$G_icid= isset($_GET['icid']) ? intval($_GET['icid']) : 0;
$G_grp = isset($_GET['pswd']) ? ($_GET['pswd']) : '';
$G_gpwd= isset($_GET['gpswd']) ? ($_GET['gpswd']) : '';
$G_md5 = isset($_GET['md5']) ? ($_GET['md5']) : '';
$U_lat = isset($_GET['lat']) ? ($_GET['lat']) : 0; 
$U_lng = isset($_GET['lng']) ? ($_GET['lng']) : 0;
$U_alt = isset($_GET['alt']) ? ($_GET['alt']) : 0;
$U_time= isset($_GET['time'])? ($_GET['time']): '';
$U_md6 = isset($_GET['md6']) ? ($_GET['md6']) : '';

$DB = new DBOBJ_PDO_SQLITE();
$DB->connect('data.db');

$ret = '';
switch ($G_aid) {
    case 1:$ret = create_group($G_did, $G_name, $G_icid, $G_grp, $G_gpwd);break;
    case 2:$ret = join_group($G_did, $G_name, $G_icid, $G_grp);break;
    case 3:$ret = del_group($G_did, $G_name, $G_grp, $G_gpwd);break;
    case 4:$ret = update_gps($G_did, $G_grp, $U_lat, $U_lng, $U_alt, $U_time);break;
    case 5:$ret = get_gps($G_did, $G_grp);break;
    default:break;
}
echo $ret;
?>
