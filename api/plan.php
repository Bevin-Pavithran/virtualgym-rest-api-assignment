<?php
header('Content-Type: application/json');
// Connect to database
require 'config.php';

$conn = mysqli_connect($host,$user,$pwd,$database);

$method = $_SERVER["REQUEST_METHOD"];
switch($method)	{
	case 'GET':
		// List plans
		getRequest();
		break;
	case 'POST':
		// Add new plan
		postRequest();
		break;
	case 'PUT':
		// Update plan
		updateRequest();
		break;
	case 'DELETE':
		// Delete Plan
		deleteRequest();
		break;
	default:
		// Invalid Request Method
		header("HTTP/1.0 405 Method Not Allowed");
		break;
}

function postRequest()
{
	global $conn;
	
	if(isset($_POST['action'])) {
		$addPlanAction = $_POST['action']; //addplanuser : assign plan to a user, addplan: add a new plan
		switch ($addPlanAction) {
			case 'addplan':
				$planName = mysqli_real_escape_string($conn, $_POST["plan_name"]);
				if(!empty($planName)) {
					$query = "INSERT INTO vgym_plans SET plan_name='".$planName."'";
					$result = mysqli_query($conn, $query);
					if($result)	{
						$insert = array('ID' => $result->insert_id );
						response(200,'Plan Added', $insert);
					} else {
						response(500,'Internal Server Error',NULL);
					}	
				} else {
					response(400,'Invalid Parameters',NULL);
				}		
				break;
			case 'addplanuser': //add user  to plan using post
				$planId = mysqli_real_escape_string($conn, $_POST['plan_id']);
				$userId = mysqli_real_escape_string($conn, $_POST['user_id']);
				$userEmail = getUserEmail($userId);
				if(is_numeric($planId)&& is_numeric($userId)) { 
					$searchQuery = mysqli_query($conn, "SELECT * FROM vgym_user_plan WHERE user_id=".$userId);
					if($searchQuery->num_rows > 0 ) {
						$updateQuery = "UPDATE vgym_user_plan SET plan_id=".$planId." WHERE user_id=".$userId;
						if(mysqli_query($conn, $updateQuery)) {
							$emailSubject = "Your workout plan has been changed";
							$emailMessage = "You have been assigned to a new plan. Kindly have a look at the updated  plan preview.";
							sendEmail($userEmail,$subject,$message);
							response(200,'User added to plan',NULL);
						} else {
							response(500,'Internal Server Error',NULL);
						}
					} else {
						$query = "INSERT INTO vgym_user_plan SET plan_id=".$planId.",user_id=".$userId;
						if(mysqli_query($conn, $query)) {
							$emailSubject = "You have been assigned to a plan";
							$emailMessage = "You have been assigned to a plan. Kindly have a look at the plan preview.";
							sendEmail($userEmail,$subject,$message);
							response(200,'User added to plan',NULL);
						} else {
							response(500,'Internal Server Error',NULL);
						}
					}
				} else {
					response(400,'Invalid Parameters',NULL);
				}
				break;
			case 'adduser':
				$userFirstname = mysqli_real_escape_string($conn, $_POST['user_firstname']);
				$userLastname = mysqli_real_escape_string($conn, $_POST['user_lastname']);
				$userEmail = mysqli_real_escape_string($conn, $_POST['user_email']);

				if((!empty($userFirstname)) && (!empty($userLastname)) && (!empty($userEmail))) {
					$query = "INSERT INTO vgym_users SET user_firstname = '".$userFirstname."', user_lastname = '".$userLastname."', user_email = '".$userEmaill."'";
					if(mysqli_query($conn, $query)) {
							response(200,'User added',NULL);
					} else {
							response(500,'Internal Server Error',NULL);
					} 	
				} else {
					response(400,'Invalid Parameters',NULL);
				}
				break;
			case 'addexercise':
					$exerciseName = mysqli_real_escape_string($conn,$_POST['exercise_name']);
					if(!empty($exerciseName)) {
						$query = "INSERT INTO vgym_exercises SET exercise_name = '".$exerciseName."'";
						if(mysqli_query($conn, $query)) {
							response(200,'Exercise added',NULL);
						} else {
							response(500,'Internal Server Error',NULL);
						}	
					} else {
						response(400,'Invalid Parameters',NULL);
					}
					break;
			case 'addday':
				$planId = mysqli_real_escape_string($conn, $_POST['plan_id']);
				$dayName = mysqli_real_escape_string($conn, $_POST['day_name']);
				$emailSubject = "New day added to plan";
				$emailMessage = "New day added to your plan. Have a look at your changes.";
				if(is_numeric($planId) && !empty($dayName)) {
					$query = "INSERT INTO vgym_plan_days SET plan_id=".$planId.",plan_day_name='".$dayName."'";
					if(mysqli_query($conn, $query)) {
						//emailquery
						$newDayId = $conn->insert_id;
						$query = "SELECT us.user_email FROM vgym_users us JOIN vgym_user_plan up ON us.ID = up.user_id JOIN vgym_plans pl ON up.plan_id = pl.ID JOIN vgym_plan_days pd ON pl.ID = pd.plan_id WHERE pd.plan_day_id = $newDayId";
						$result = mysqli_query($conn, $query);
						if($conn->num_rows > 0) {
							while ($user = mysqli_fetch_assoc($result)) {
								sendEmail($user['user_email'],$emailSubject,$emailMessage);
							}
						}
						response(200,'Day added to plan',NULL);
					} else {
						response(500,'Internal Server Error1',NULL);
					}
				} else {
					response(400,'Invalid Parameters',NULL);
				}
				break;
			case 'adddayexercise':
				$dayId = mysqli_real_escape_string($conn, $_POST['day_id']);
				$exerciseId = mysqli_real_escape_string($conn, $_POST['exercise_id']);
				$emailSubject = "New exercise added to your day.";
				$emailMessage = "New Exercise has been added to a day in your workout plan. Have a look at your plan.";
				if(is_numeric($dayId) && is_numeric($exerciseId)) {
					$checkIfExist = mysqli_query($conn, "SELECT * FROM vgym_plan_day_exercises WHERE plan_day_id = $dayId AND exercise_id = $exerciseId");
					if($checkIfExist->num_rows == 0) {
						$query = "INSERT INTO vgym_plan_day_exercises SET plan_day_id = '$dayId' ,exercise_id = '$exerciseId' ";
						if(mysqli_query($conn, $query)) {
							$query = "SELECT us.user_email FROM vgym_users us JOIN vgym_user_plan up ON us.ID = up.user_id JOIN vgym_plans pl ON up.plan_id = pl.ID JOIN vgym_plan_days pd ON pl.ID = pd.plan_id WHERE pd.plan_day_id = $dayId";
							$result = mysqli_query($conn, $query);
							if($conn->num_rows > 0) {
								while ($user = mysqli_fetch_assoc($result)) {
									sendEmail($user['user_email'],$emailSubject,$emailMessage);
								}
							}
							response(200,'Exercise added to day',NULL);
						} else {
							response(500,'Internal Server Error',NULL);
						}
					} else {
						response(400,'Duplicate Entry',NULL);
					}
				} else {
					response(400,'Invalid Parameters',NULL);
				}
				break;
			default:
				response(400,'Invalid Action',NULL);
			break;
		}		
	} else {
		response(400,'Missing Action Parameter',NULL);
	}	 
}

function getRequest() {
	global $conn;
	$action = $_GET['action'];
	if(!empty($action)) {
		switch ($action) {
			case 'getallplans':  //action=getallplans
				$response=array();
				$result=mysqli_query($conn, "SELECT * FROM vgym_plans");
				if($result->num_rows > 0) {
					while($row=mysqli_fetch_assoc($result))
					{
						$rowArray = array();
						$rowArray['planId'] = $row['ID'];
						$rowArray['planName'] = $row['plan_name'];
						array_push($response, $rowArray);
					}
					response(200,'Plans Found',$response);	
				} else {
					response(200,'No Plans Found',NULL);
				}
				break;
			case 'getplanbyid':
				$planId = $_GET["planid"];
				$response = array();
				if(is_numeric($planId)) {
					$query = "SELECT * FROM vgym_plans WHERE ID = $planId";
					$result = mysqli_query($conn, $query);
					if($result->num_rows > 0 ) {
						$response = mysqli_fetch_assoc($result);
						response(200,'Plan Found',$response);
					} else {
						response(200,'No Plan Found',NULL);
					}
				} else {
					response(400,'Invalid Parameter',NULL);
				}
				break;	
			case 'getplandaysbyid':  //action=getplandaysbyid&planid=1 with exercises
				$planId = $_GET["planid"];
				$planId = mysqli_real_escape_string($conn,$planId);
				//get days and excercise for planid
				$response = array();
				$daysQuery = mysqli_query($conn,"SELECT * FROM vgym_plan_days WHERE plan_id =".$planId);
				if($daysQuery->num_rows > 0) {
					while ($row = mysqli_fetch_array($daysQuery)) {
						$rowArray = array();
						$rowArray['planDayId'] = $row['plan_day_id'];
						$rowArray['planDayName'] = $row['plan_day_name'];
						$rowArray['planDayExercises'] = array();
						$dayId = $row['plan_day_id'];

						$exerciseQuery = mysqli_query($conn, "SELECT * FROM vgym_plan_day_exercises WHERE plan_day_id =".$dayId);
						while ($exercisesRow = mysqli_fetch_array($exerciseQuery)) {
							$exerciseId = $exercisesRow['exercise_id'];
							$exerciseInnerQuery = mysqli_query($conn, "SELECT * FROM vgym_exercises WHERE ID =".$exerciseId);
							while ($exerciseRow = mysqli_fetch_array($exerciseInnerQuery)) {
								$rowArray['planDayExercises'][] = array(
									'ID' => $exerciseRow['ID'],
									'exerciseName' => $exerciseRow['exercise_name']
								);
							}
						}
						array_push($response, $rowArray);
					}
					response(200,'Plan Days Found',$response);
				} else {
					response(200,'No Days Found',NULL);
				} 
				break;					
			case 'getallusers':	  //action=getallusers
				$response = array();
				$result = mysqli_query($conn, "SELECT * FROM vgym_users");
				if($result->num_rows > 0) {
					while($row = mysqli_fetch_assoc($result))
					{
						$rowArray = array();
						$rowArray['userId'] = $row['ID'];
						$rowArray['userFirstname'] = $row['user_firstname'];
						$rowArray['userLastname'] = $row['user_lastname'];
						$rowArray['userEmail'] = $row['user_email'];
						$rowArray['planId'] = "";
						$planResult = mysqli_query($conn, "SELECT * FROM vgym_user_plan WHERE user_id = ".$row['ID']);
						if($planResult->num_rows > 0) {
							$planRow = mysqli_fetch_assoc($planResult);
							$rowArray['planId'] = $planRow['plan_id'];
						}
						array_push($response, $rowArray);
					}
					response(200,'Users Found',$response);	
				} else {
					response(200,'No Users Found',NULL);
				}
				break;
			case 'getallexercises':
				$response = array();
				$result = mysqli_query($conn, "SELECT * FROM vgym_exercises");
				if($result->num_rows > 0){
					while($row = mysqli_fetch_assoc($result)) {
						$rowArray = array();
						$rowArray['exerciseId'] = $row['ID'];
						$rowArray['exerciseName'] = $row['exercise_name'];
						array_push($response, $rowArray);	
					}
					response(200,'Exercises Found',$response);	
				} else {
					response(200,'No Exercises Found',$response);	
				}
				break;	
			case 'getuserbyid':  //action=getuserbyid&userid=1
				$userId = $_GET['userid'];
				$response = array();
				if(is_numeric($userId)) {
					$result=mysqli_query($conn, "SELECT * FROM vgym_users WHERE ID = $userId");
					if($result->num_rows > 0) {
						while($row=mysqli_fetch_assoc($result))
						{
							$rowArray = array();
							$rowArray['userId'] = $row['ID'];
							$rowArray['userFirstname'] = $row['user_firstname'];
							$rowArray['userLastname'] = $row['user_lastname'];
							$rowArray['userEmail'] = $row['user_email'];
							array_push($response, $rowArray);
						}
						response(200,'User Found',$response);	
					} else {
						response(200,'No User Found',NULL);
					}
				} else {
					response(400,'Invalid Parameter',NULL);
				}
				break;
			default:
				response(400,'Invalid Action',NULL);
				break;
		} // end of switch
	} else {
		response(400,'Missing Action Parameter',NULL);
	}	
}

function deleteRequest() {
	global $conn;
	if(!empty($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'deleteplan':
				if(!empty($_GET['planid'])) {
					$planId = intval($_GET["planid"]);
					$planId = mysqli_real_escape_string($conn,$planId);
					$query = "DELETE FROM vgym_plans WHERE ID = $planId";
					if(mysqli_query($conn, $query))	{
						//if(mysqli_query($conn, "DELETE FROM vgym_plans WHERE ID = $planId";)) {
							response(200,'Plan Deleted',NULL);
						//} else {
							//response(500,'Internal Server Error1',NULL);
						//}
					} else {
						response(500,$query,NULL);
					}
				} else {
					response(400,'Empty Plan ID',NULL);	
				}
				break;
			case 'deleteday':
				if(!empty($_GET['dayid'])) {
					$dayId = $_GET["dayid"];
					if(is_numeric($dayId)) {
						$query = "DELETE FROM vgym_plan_day_exercises WHERE plan_day_id =".$dayId;
						if(mysqli_query($conn, $query))	{
							if(mysqli_query($conn, "DELETE FROM vgym_plan_days WHERE plan_day_id =".$dayId)){
								response(200,'Day Deleted',NULL);
							} else {
								response(500,'Internal Server Error1',NULL);
							}
						} else {
							response(500,'Internal Server Error1',NULL);
						}	
					} else {
						response(400,'Invalid Parameter',NULL);
					}
					
				} else {
					response(400,'Empty Day ID',NULL);
				}
				break;
			case 'deletedayexercise':
				if(!empty($_GET['dayid']) && !empty($_GET['exerciseid'])) {
					$dayId = $_GET['dayid'];
					$exerciseId = $_GET['exerciseid'];
					if(is_numeric($dayId) && is_numeric($exerciseId)) {
						$query = "DELETE FROM vgym_plan_day_exercises WHERE plan_day_id = $dayId AND exercise_id = $exerciseId";
						if(mysqli_query($conn, $query))	{
							response(200,'Exercise Deleted',NULL);
						} else {
							response(500,'Internal Server Error',NULL);
						}
					} else {
						response(400,'Invalid Parameters',NULL);
					}						
				} else {
					response(400,'Empty Exercise ID or Day ID',NULL);	
				}
				break;
			case 'deleteexercise':
				if(!empty($_GET['exerciseid'])) {						
					$exerciseId = $_GET['exerciseid'];
					if(is_numeric($exerciseId)) {
						$query = "DELETE FROM vgym_plan_day_exercises WHERE exercise_id = $exerciseId";							
						if(mysqli_query($conn, $query)) {
							if(mysqli_query($conn, "DELETE FROM vgym_exercises WHERE ID = $exerciseId")) {
								response(200,'Exercise Deleted',NULL);
							} else {
								response(500,'Internal Server Error',NULL);	
							}
						} else {
							response(500,'Internal Server Error',NULL);
						}
					} else {
						response(400,'Invalid Parameters',NULL);
					}						
				} else {
					response(400,'Empty Exercise ID',NULL);	
				}
				break;
			case 'deleteuserplan':
				if(!empty($_GET['userid'])) {						
					$userId = $_GET['userid'];
					if(is_numeric($userId)) {
						$query = "DELETE FROM vgym_user_plan WHERE user_id = $userId";
						if(mysqli_query($conn, $query)) {
							response(200,'Plan removed',NULL);
						} else {
							response(500,'Internal Server Error1',NULL);
						}
					} else {
						response(400,'Invalid Parameters',NULL);
					}						
				} else {
					response(400,'Empty User ID',NULL);	
				}
				break;
			case 'deleteuser':
				if(!empty($_GET['userid'])) {
					$userId = $_GET['userid'];
					if(is_numeric($userId)) {
						$query = "DELETE FROM vgym_user_plan WHERE user_id = $userId";
						if(mysqli_query($conn, $query)) {
							$query = "DELETE FROM vgym_users WHERE ID = $userId";
							if(mysqli_query($conn, $query)) {
								response(200,'User Deleted',NULL);	
							} else {
								response(500,'Internal Server Error1',NULL);
							}
						} else {
							response(500,'Internal Server Error1',NULL);
						} 
					} else {
						response(400,'Invalid Parameters',NULL);
					}
				} else {
					response(400,'Empty User ID',NULL);
				}
				break;								
			default:
				response(400,'Invalid Action',NULL);
				break;
		}
	} else {
		response(400,'Missing Action Parameter',NULL);
	}
}

function updateRequest()
{
	global $conn;
	if(!empty($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'updateplan':
				$planId = $_GET['planid'];
				parse_str(file_get_contents("php://input"),$postItems);					
				$planName = mysqli_real_escape_string($conn,$postItems['planname']);
				if(is_numeric($planId) && !empty($planName)) {
					$query="UPDATE vgym_plans SET plan_name='".$planName."' WHERE ID=".$planId;
					if(mysqli_query($conn, $query)) {
						response(200,'Plan updated',NULL);
					} else {
						response(500,'Internal Server Error1',NULL);
					}	
				} else {
					response(400,'Invalid Parameters',NULL);
				}
				break;
			case 'updateDay':
				$dayId = $_GET['dayid'];
				parse_str(file_get_contents("php://input"), $postItems);
				$dayName = mysqli_real_escape_string($conn, $postItems['dayname']);
				if(is_numeric($dayId) && !empty($dayName)) {
					$query="UPDATE vgym_plan_days SET plan_day_name='".$dayName."' WHERE plan_day_id=".$dayId;
					if(mysqli_query($conn, $query))	{
						response(200,'Day Updated',NULL);
					} else	{
						response(500,'Internal Server Error1',NULL);
					}	
				} else {
					response(400,'Invalid Parameters',NULL);
				}	
				break;
			case 'updateExercise':
				$exerciseId = $_GET['exerciseid'];
				parse_str(file_get_contents("php://input"), $postItems);
				$exerciseName = mysqli_real_escape_string($conn, $postItems['exercisename']);
				if(is_numeric($exerciseId) && !empty($exerciseName)) {
					$query="UPDATE vgym_exercises SET exercise_name='".$exerciseName."' WHERE ID=".$exerciseId;
					if(mysqli_query($conn, $query))	{
						response(200,'Exercise Updated',NULL);
					} else {
						response(500,'Internal Server Error1',NULL);
					}	
				} else {
					response(400,'Invalid Parameters',NULL);
				}
				break;			
			case 'updateUser':
				$userId = $_GET['userid'];
				parse_str(file_get_contents("php://input"), $postItems);
				$userFirstame = mysqli_real_escape_string($conn, $postItems['firstname']);
				$userLastname = mysqli_real_escape_string($conn, $postItems['lastname']);
				$userEmail = mysqli_real_escape_string($conn, $postItems['useremail']);
				if(is_numeric($userId)) {
					$query="UPDATE vgym_users SET user_firstname='$userFirstname', user_lastname = '$userLastname', user_email = '$user_email' WHERE ID=".$userId;
					if(mysqli_query($conn, $query))	{
						response(200,'User Updated',NULL);
					} else {
						response(500,'Internal Server Error1',NULL);
					}	
				} else {
					response(400,'Invalid Parameters',NULL);	
				}
				break;					
			default:
				response(400,'Invalid Action',NULL);	
				break;
		}
	} else {
		response(400,'Missing Action Parameter',NULL);
	}	
}

function getUserEmail($userId) {
	$result = mysqli_query($conn, "SELECT user_email FROM vgym_users WHERE ID=".$userId);
	if($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		return $row['user_email'];
	} else {
		return false;
	}
}

function sendEmail($email,$subject,$message) {
	mail($email,$subject,$message);
}

function response($status,$status_message,$data)
{

	$response['status']=$status;
	$response['status_message']=$status_message;
	$response['data']=$data;
	
	$json_response = json_encode($response);
	echo $json_response;
}

// Close database connection
mysqli_close($conn);


?>
