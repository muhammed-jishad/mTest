<?php 
	class Api extends Rest {
		
		public function __construct() {
			parent::__construct();
		}

		public function generateToken() {
			$apuser = $this->validateParameter('client_id', $this->param['client_id'], STRING);
			$apkey = $this->validateParameter('client_secret', $this->param['client_secret'], STRING);
			try {
				$stmt = $this->dbConn->prepare("SELECT * FROM tbl_apiusers WHERE ap_user = :apuser AND ap_key = :key");
				$stmt->bindParam(":apuser", $apuser);
				$stmt->bindParam(":key", $apkey);
				$stmt->execute();
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
				if(!is_array($user)) {
					$this->returnResponse(INVALID_USER_PASS, "Username or key is incorrect.");
				}

				if( $user['ap_status'] != 0 ) {
					$this->returnResponse(USER_NOT_ACTIVE, "User is not activated. Please contact to admin.");
				}
				$expsec=120*60;
				$exp=time()+($expsec);
				$paylod = Array(
					'iat' => time(),
					'iss' => 'localhost',
					'exp' => $exp,
					'userId' => $user['ap_id']
				);

				$token = JWT::encode($paylod, SECRETE_KEY);
				
				$data = Array('token' => $token,'expire' => $expsec);
				$this->returnResponse(SUCCESS_RESPONSE, $data);
			} catch (Exception $e) {
				$this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
			}
		}
public function Login(){
			$username = $this->validateParameter('username', $this->param['param']['username'], STRING);
			$password = $this->validateParameter('password', $this->param['param']['password'], STRING);
			try {
				$stmt = $this->dbConn->prepare("SELECT * FROM tbl_user WHERE email = '$username' AND password = '$password'");
				$stmt->execute();
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
				if(!is_array($user)) {
					$this->returnResponse(INVALID_USER_PASS, "Username or key is incorrect.");
				}
				if( $user['user_status'] != 0 ) {
					$this->returnResponse(USER_NOT_ACTIVE, "User is not activated. Please contact to admin.");
				}
				$data = Array('user' => $user);
				$this->returnResponse(SUCCESS_RESPONSE, $data);
			} catch (Exception $e) {
				$this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
			}
}		
public function Register(){
			$username = $this->validateParameter('username', $this->param['username'], STRING);
			$password = $this->validateParameter('password', $this->param['password'], STRING);
			$email = $this->validateParameter('email', $this->param['email'], STRING);
			try {
				$usersql="INSERT INTO tbl_user(username,password,email) VALUES ('$username','$password','$email')";
$usersql = $this->dbConn->prepare($usersql);
$usersql->execute();
				$data = Array('status' => "success");
				$this->returnResponse(SUCCESS_RESPONSE, $data);
			} catch (Exception $e) {
				$this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
			}
}	
public function getUser(){
$usersql = "SELECT tb.user_id,tb.username,tb.password,tb.email,tb.user_status FROM tbl_user tb";
$userstmt = $this->dbConn->prepare($usersql);
$userstmt->execute();
$user = $userstmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($user as $key => $us) {
$userdata[$us["user_id"]]=Array("id"=>$us["user_id"],"name"=>$us["username"],"email"=>$us["email"],"status"=>$us["user_status"]);
}
$this->returnResponse(SUCCESS_RESPONSE, $userdata);
}
public function Updateuser(){
	$username = $this->validateParameter('username', $this->param['username'], STRING);
	$password = $this->validateParameter('password', $this->param['password'], STRING);
	$email = $this->validateParameter('email', $this->param['email'], STRING);
	$userid = $this->validateParameter('uid', $this->param['uid'], STRING);
try {
$upstsql="UPDATE tbl_user SET username='$username',password='$password',email='$email' WHERE    user_id='$userid'";
$odres = $this->dbConn->prepare($upstsql);
$odres->execute();
$data = Array('status' => "success");
				$this->returnResponse(SUCCESS_RESPONSE, $data);
			} catch (Exception $e) {
				$this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
			}
}
public function Deleteuser(){
	$userid = $this->validateParameter('uid', $this->param['uid'], STRING);
try {
$updtsql="DELETE FROM tbl_user WHERE user_id='$userid'";
$odres = $this->dbConn->prepare($updtsql);
$odres->execute();
$data = Array('status' => "success");
				$this->returnResponse(SUCCESS_RESPONSE, $data);
			} catch (Exception $e) {
				$this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
			}
}

public function getSecurityTransactions() {
	try{
 $transsql = "SELECT st.TRADE_DATE, st.SECURITY_ACCOUNT AS Portfolio_Number, sam.ACCOUNT_NAME AS Name_of_Client, st.SECURITY_NUMBER AS Share_Symbol_Code, sm.SHORT_NAME AS Share_Name, st.TRANS_TYPE AS Transaction_Type, st.RECID AS Transaction_ID, st.NO_NOMINAL AS No_of_Shares, st.PRICE AS Unit_Price, st.NET_AMT_TRADE AS Net_Amount, st.BROKER_COMMS AS Brokerage_Other_Charges, st.GROSS_AMT_TRD_CURR AS Total_Amount, st.PROF_LOSS_SEC_CCY AS Profit_Loss FROM Security_Transactions st LEFT JOIN Security_Acc_Master sam ON st.SECURITY_ACCOUNT = sam.acc_id LEFT JOIN Security_Master sm ON st.SECURITY_NUMBER = sm.Master_id";
 $stmt = $this->dbConn->prepare($transsql);
 $stmt->execute();
 $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
$this->returnResponse(SUCCESS_RESPONSE, $transactions);
} catch (Exception $e) {
				$this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
			}
}
	}
	
 ?>