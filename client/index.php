 <?php 
/*
*
*
*/

require_once('header.php');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row ">
        <div class="col-lg-4">
                <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i> 
                    Plans
                </div>
                <div class="panel-body" id="plan-list">
                    
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default btn-block" onclick="showPlanForm()"><i class="glyphicon glyphicon-plus"></i>Add Plan</button>
                </div>
                </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-users"></i> 
                    Users
                </div>
                <div class="panel-body" id="user-list">
                    
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default btn-block" onclick="showUserForm()"><i class="glyphicon glyphicon-plus"></i>Add User</button>
                </div>
            </div>
        </div>
        <!-- /.col-lg-4 -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-list-alt"></i> 
                    Exercise
                </div>
                <div class="panel-body" id="exercise-list"></div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default btn-block" onclick="showExerciseForm()"><i class="glyphicon glyphicon-plus"></i>Add Exercise</button>
                </div>
            </div>
        </div>
        <!-- /.col-lg-4 -->        
    </div>
    <!-- /.row -->
    <div class="row hidden" id="plan-overview" tabindex='1'>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <input type="hidden" id="plan-id-overview">
                    <span id="plan-name"></span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6" id="plan-days">
                        </div>
                        <!-- /.col-lg-6-->
                        <div class="col-lg-6">
                            <div class="well">
                                <div class="panel-group" id="exercise-plan-list">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="pull-right btn btn-default btn-sm" onclick="hidePlanOverview()">Close</button>
                </div>
                <!-- /.panel-body -->       
            </div>
            <!-- /.panel-default -->
        </div> 
        <!-- /.col-lg-12 -->
    </div>
    <!-- / .row -->
    <div class="row hidden" id="addUserPanel">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Users
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Firstname</label>
                        <input class="form-control" type="text" name="firstname" id="userFirstnameInput" placeholder="Firstname">
                    </div>
                    <div class="form-group">
                        <label>Lastname</label>
                        <input class="form-control" type="text" name="lastname" id="userLastnameInput" placeholder="Lastname">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" name="useremail" id="userEmailInput" placeholder="abc@xyz.com">
                    </div>
                    <button type="submit" class="btn btn-default" onclick="addUser()">Add</button>
                    <button type="reset" class="btn btn-default" onclick="hideUserForm()">Close</button>
                </div>
            </div>
            <!-- /.panel-default -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <!-- / .row -->
    <div class="row hidden" id="addPlanPanel">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Plan
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Plan Name</label>
                        <input class="form-control" name="planname" id="planNameInput" placeholder="Plan name">
                    </div>
                    <button type="submit" class="btn btn-default" onclick="addPlan()">Save</button>
                    <button type="reset" class="btn btn-default" onclick="hidePlanForm()">Cancel</button>
                </div>
            </div>
            <!-- /.panel-default -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row --> 
    <!-- / .row -->
    <div class="row hidden" id="addExercisePanel">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Exercise
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Exercise Name</label>
                        <input class="form-control" name="planname" id="exerciseNameInput" placeholder="Exercise name">
                    </div>
                    <button type="submit" class="btn btn-default" onclick="addExercise()">Save</button>
                    <button type="reset" class="btn btn-default" onclick="hideExerciseForm()">Cancel</button>
                </div>
            </div>
            <!-- /.panel-default -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->               
</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<?php 
require_once('footer.php');
?>

<script type="text/javascript">

    /*
    * Set baseUrl to api url
    */
    var baseUrl = "http://localhost:3001";
    var planListContainer = $('#plan-list');
    var userListContainer = $('#user-list');
    var exerciseListContainer = $('#exercise-list');
    var exerciseListPlan = $('#exercise-plan-list');


    function hasValue(data) {
        return (data !== undefined) && (data !== null) && (data !== "");
    }

    function showPlanForm() {
        $('#addPlanPanel').removeClass('hidden');
    }
    function hidePlanForm() {
        $('#addPlanPanel').addClass('hidden');   
    }

    function showUserForm() {
        $('#addUserPanel').removeClass('hidden');
    }

    function hideUserForm() {
        $('#addUserPanel').addClass('hidden');   
    }
    function showExerciseForm() {
        $('#addExercisePanel').removeClass('hidden');
    }

    function hideExerciseForm() {
        $('#addExercisePanel').addClass('hidden');   
    }
    
    function addPlan() {
        var planName = $('#planNameInput').val();
        $('#addPlanPanel').addClass('hidden');
        $('#planNameInput').val('');

        $.ajax({
            type :"POST",
            url : baseUrl+"/virtualgym/api/plan.php",
            data : {
                'action' : 'addplan',
                'plan_name' : planName,
            },           
            success: function(response,status,http) {
                if(response.status == 200){
                    getPlans();
                    getUsers();
                    swal('Add Plan', response.status_message, 'success');
                } else if((response.status == 500) || (response.status == 400)) {
                    swal('Add Plan', response.status_message, 'error');    
                }  
            }
        });

    }

    function getPlans() {
        planListContainer.html('');
        $.ajax({
            type:"GET",
            url: baseUrl+"/virtualgym/api/plan.php?action=getallplans",           
            success: function(response,status,http) {
                if(hasValue(response.data)){
                    for (var i = 0; i < response.data.length; i++) {
                        var planName = response.data[i]['planName'];
                        var planId = response.data[i]['planId'];
                        planListContainer.append('<div class="panel panel-default" id="plan-list-item-'+planId+'">'+
                                    '<div class="panel-heading">'+
                                        '<h4 class="panel-title"><span id="plan-list-item-title-'+planId+'">'+planName+
                                            '</span><a data-toggle="collapse" data-parent="#plan-list" href="#plan_panel_'+planId+'" aria-expanded="false" class="collapsed">'+
                                                '<span class="pull-right text-muted small">'+
                                                    '<i class="glyphicon glyphicon-pencil"></i>'+
                                                '</span>'+
                                            '</a>'+
                                        '</h4>'+
                                    '</div>'+
                                    '<div id="plan_panel_'+planId+'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">'+
                                        '<div class="panel-body">'+
                                            '<div class="form-group">'+
                                                '<label>Plan Name</label>'+
                                                    '<input class="form-control" type="text" name="planname" id="plan-name-'+planId+'" value="'+planName+'">'+ 
                                            '</div>'+
                                            '<button data-toggle="collapse" data-parent="#plan-list" href="#plan_panel_'+planId+'" class="btn btn-default" onclick="updatePlan('+planId+')">Update</button>  '+
                                            '<button data-toggle="collapse" data-parent="#plan-list" href="#plan_panel_'+planId+'" class="btn btn-default" onclick="getPlanOverview('+planId+')">Plan Overview</button>  '+
                                            '<button data-toggle="collapse" data-parent="#plan-list" href="#plan_panel_'+planId+'" class="btn btn-outline btn-primary" onclick="removePlan('+planId+')">Delete</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                    }
                } else {
                    planListContainer.append('<p class="text-muted">Add your first plan</p>');
                }
           }
        });
    }

    function addUser() {
        var userFirstame = $('#userFirstnameInput').val();
        var userLastame = $('#userLastnameInput').val();
        var userEmail = $('#userEmailInput').val();
        $.ajax({
            type :"POST",
            url : baseUrl+"/virtualgym/api/plan.php",
            data : {
                'action' : 'adduser',
                'user_lastname' : userLastame,
                'user_firstname' : userFirstame,
                'user_email' : userEmail 
            },           
            success: function(response,status,http) {
                if(response.status == 200){
                    getUsers();
                    $('#addUserPanel').addClass('hidden');
                    swal('Add user', response.status_message, 'success');
                    $('#userFirstnameInput').val('');
                    $('#userLastnameInput').val('');
                    $('#userEmailInput').val('');
                    hideUserForm();
                } else if((response.status == 500) || (response.status == 400)) {
                    swal('Add user', response.status_message, 'error');    
                }  
            }
        });

    }

    function addExercise() {
        var exerciseName = $('#exerciseNameInput').val();        
        $.ajax({
            type :"POST",
            url : baseUrl+"/virtualgym/api/plan.php",
            data : {
                'action' : 'addexercise',
                'exercise_name' : exerciseName
            },           
            success: function(response,status,http) {
                if(response.status == 200){
                    getUsers();
                    $('#addUserPanel').addClass('hidden');
                    swal('Add user', response.status_message, 'success');
                    getExercises('mainlist');
                    getExercises('planlist');
                    $('#exerciseNameInput').val('');                    
                    hideExerciseForm();
                } else if((response.status == 500) || (response.status == 400)) {
                    swal('Add user', response.status_message, 'error');    
                }  
            }
        });

    }

    function getUsers() {
        $.ajax({
            type:"GET",
            url: baseUrl+"/virtualgym/api/plan.php?action=getallusers",           
            success: function(response,status,http) {
                if(hasValue(response.data)) {
                    userListContainer.html('');
                    for (var i = 0; i < response.data.length; i++) {
                        var userId = response.data[i]['userId'];
                        var firstname = response.data[i]['userFirstname'];
                        var lastname = response.data[i]['userLastname'];
                        var planId = response.data[i]['planId'];
                        
                        userListContainer.append('<div class="panel panel-default" id="user-list-item-'+userId+'">'+
                                    '<div class="panel-heading">'+
                                        '<h4 class="panel-title"><span id="user-list-item-title-'+userId+'">'+firstname+' '+lastname+
                                            '</span><a data-toggle="collapse" data-parent="#plan-list" href="#user_panel_'+userId+'" aria-expanded="false" class="collapsed">'+
                                                '<span class="pull-right text-muted small">'+
                                                    '<i class="glyphicon glyphicon-pencil"></i>'+
                                                '</span>'+
                                            '</a>'+
                                        '</h4>'+
                                    '</div>'+
                                    '<div id="user_panel_'+userId+'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">'+
                                        '<div class="panel-body">'+
                                            '<div class="form-group">'+
                                                '<label>Assign Plan</label>'+
                                                    '<select class="form-control plan-user-dropdown" id="plan-select-'+userId+'">'+
                                                    '</select>'+
                                            '</div>'+
                                            '<button data-toggle="collapse" data-parent="#plan-list" href="#user_panel_'+userId+'" class="btn btn-default" onclick="updateUserPlan('+userId+')">Update</button> '+
                                            '<button data-toggle="collapse" data-parent="#plan-list" href="#user_panel_'+userId+'" class="btn btn-default" onclick="deleteUser('+userId+')">Delele</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                        if(planId != "") {
                            addPlanOptions(userId, planId);
                        } else {
                            addPlanOptions(userId, "");
                        }
                    }
                } else {
                    userListContainer.append('<p class="text-muted">Add your first user</p>');
                }
           }
        });
    }

    function addPlanOptions(userId, userPlanId) {
        $.ajax({
            type:"GET",
            url: baseUrl+"/virtualgym/api/plan.php?action=getallplans",
            success: function(response,status,http) {
                $('#plan-select-'+userId).empty();
                if(userPlanId == "") {
                    $('#plan-select-'+userId).append($("<option></option>").attr("value","noplan").text('Select Plan').prop('selected', true).prop('disabled', true));
                }
                if(hasValue(response.data)) {
                    for (var i = 0; i < response.data.length; i++) {
                        var planName = response.data[i]['planName'];
                        var planId = response.data[i]['planId'];
                        if(userPlanId === planId) {
                            $('#plan-select-'+userId).append($("<option></option>").attr("value",planId).text(planName).prop('selected', true));     
                        } else {
                            $('#plan-select-'+userId).append($("<option></option>").attr("value",planId).text(planName));
                        }            
                        
                    }
                }
            }
        });
    }

    function updateUserPlan(userId) {
        var selectedPlanId = $('#plan-select-'+userId+" option:selected").val();
        $.ajax({
            type :"POST",
            url : baseUrl+"/virtualgym/api/plan.php",
            data : {
                'action' : 'addplanuser',
                'user_id' : userId,
                'plan_id' : selectedPlanId,
            },           
            success: function(response,status,http) {
                if(response.status == 200){
                    swal('Assign Plan', response.status_message, 'success');
                    addPlanOptions(userId, selectedPlanId);
                } else if((response.status == 500) || (response.status == 400)) {
                    swal('Assign Plan', response.status_message, 'error');    
                }
                
           }
        });

    }

    function deleteUser(userId) {
        $.ajax({
            type : "DELETE",
            url : baseUrl+"/virtualgym/api/plan.php?action=deleteuser&userid="+userId,
            success : function(response,status,http) {
                if(response.status == 200){
                    swal('Delete User', response.status_message, 'success');
                    $('#user-list-item-'+userId).remove();
                } else if((response.status == 500) || (response.status == 400)) {
                    swal('Delete Users', response.status_message, 'error');    
                }
            }
        });        
    }

    function getExercises(section) {
        $.ajax({
            type:"GET",
            url: baseUrl+"/virtualgym/api/plan.php?action=getallexercises",           
            success: function(response,status,http) {
                if(hasValue(response.data)) {
                    if(section == 'planlist'){
                        exerciseListPlan.html('');
                    } else if(section == "mainlist"){
                        exerciseListContainer.html('');
                    }
                    for (var i = 0; i < response.data.length; i++) {
                        if(section == 'mainlist'){
                            exerciseListContainer.append('<div class="list-group-item" id="exercise-list-item-'+response.data[i]['exerciseId']+'">'+response.data[i]['exerciseName']+'<span class="pull-right text-muted small"><button type="button" class="btn btn-danger btn-xs" onclick="deleteExercise('+response.data[i]['exerciseId']+')"><i class="fa fa-times"></i></button></span></div>');
                        } 
                        else if (section == 'planlist') {
                            var exerciseId = response.data[i]['exerciseId'];
                            var exerciseName = response.data[i]['exerciseName'];
                            exerciseListPlan.append('<div class="panel panel-default">'+
                                    '<div class="panel-heading">'+
                                        '<h4 class="panel-title">'+exerciseName+
                                            '<a data-toggle="collapse" data-parent="#exercise-plan-list" href="#collapse_'+exerciseId+'" aria-expanded="false" class="collapsed">'+
                                                '<span class="pull-right text-muted small">'+
                                                    '<i class="fa fa-plus"></i>'+
                                                '</span>'+
                                            '</a>'+
                                        '</h4>'+
                                    '</div>'+
                                    '<div id="collapse_'+exerciseId+'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">'+
                                        '<div class="panel-body">'+
                                            '<div class="form-group">'+
                                                '<label>Add to day</label>'+
                                                    '<select class="form-control day-dropdown" id="day-select-'+exerciseId+'">'+
                                                    '</select>'+
                                            '</div>'+
                                            '<button type="submit" data-toggle="collapse" data-parent="#exercise-plan-list" href="#collapse_'+exerciseId+'" class="btn btn-default" onclick="addtoday('+exerciseId+')">Add</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                        }
                    }
                } else {
                    exerciseListContainer.append('<p class="text-muted">Add your first exercise</p>');
                }
           }
        });   
    }

    function deleteExercise(exerciseId) {
        $.ajax({
            type : "DELETE",
            url : baseUrl+"/virtualgym/api/plan.php?action=deleteexercise&exerciseid="+exerciseId,
            success : function(response,status,http) {
                if(response.status == 200){
                    swal('Delete Exercise', response.status_message, 'success');
                    $('#exercise-list-item-'+exerciseId).remove();
                    getExercises('mainlist');
                    getExercises('planlist');
                } else if((response.status == 500) || (response.status == 400)) {
                    swal('Delete Exercise', response.status_message, 'error');    
                }
            }
        });        
    }

    function getPlanOverview(planId) {
        $.ajax({
            type:"GET",
            url: baseUrl+"/virtualgym/api/plan.php?action=getplanbyid&planid="+planId,           
            success: function(response,status,http) {
                if(hasValue(response.data)) {
                    $('#plan-name').html("<h3>"+response.data['plan_name']+" <small>Customize</small></h3>");
                    $('#plan-id-overview').val(planId);
                    getPlanDays(planId);
                } else {
                  swal('Plan Overview', response.status_message, 'error');      
                }
           }
        });
    }

    function getPlanDays(planId) {
        $.ajax({
            type:"GET",
            url: baseUrl+"/virtualgym/api/plan.php?action=getplandaysbyid&planid="+planId,           
            success: function(response,status,http) {
                if(hasValue(response.data)) {
                    var planDays = response.data;
                    $('#plan-days').html('');
                    $('.day-dropdown').html('');
                    for(index in planDays) {
                        var dayId = planDays[index]['planDayId'];
                        var dayItemId = 'day_'+dayId;
                        $('#plan-days').prepend('<div class="well" id="'+dayItemId+'"><h4>'+planDays[index]['planDayName']+'<span class="pull-right text-muted small"><button type="button" class="btn btn-danger btn-xs"  onclick="removeDay('+dayId+')"><i class="fa fa-times"></i></button></span></h4></div><div></div>');
                        $('.day-dropdown').append($("<option></option>").attr("value",dayId).text(planDays[index]['planDayName'])); 
                        exercises = planDays[index]['planDayExercises'];
                        for(index in exercises) {
                            exerciseId = exercises[index]['ID'];
                            $('#'+dayItemId).append('<li class="list-group-item">'+exercises[index]['exerciseName']+'<span class="pull-right text-muted small"><button type="button" class="btn btn-warning btn-xs"  onclick="removeExercise('+exerciseId+','+dayId+','+planId+')"><i class="fa fa-times"></i></button></span></li>');
                        }

                    }
                    $('#plan-days').append('<div class="panel-default">'+
                                '<div class="panel-body">'+
                                    '<button type="button" class="btn btn btn-default" onclick="showForm()"><i class="glyphicon glyphicon-plus"></i>Add Day</button>'+
                                '</div>'+
                            '</div>');
                    $('#plan-days').append('<div class="panel-default">'+
                        '<div class="panel-body">'+
                            '<div class="hidden" id="add-plan-day" >'+
                                '<div class="form-group">'+
                                  '<label for="dayName">Day</label>'+
                                  '<input type="text" class="form-control" id="day-name" placeholder="Enter day name" name="day-name">'+
                                '</div>'+
                                '<button class="btn btn-default" onclick="addDayToPlan('+planId+')">Add</button> '+
                                '<button class="btn btn-default" onclick="hideForm()">Cancel</button>'+
                            '</div'+
                            '</div>'+
                            '</div>');

                } else {
                    $('#plan-days').html('');
                    $('.day-dropdown').html('');
                    $('#plan-days').append('<p class="text-muted">Add your first day.</p>');
                    $('#plan-days').append('<div class="panel-default">'+
                                '<div class="panel-body">'+
                                    '<button type="button" class="btn btn btn-default" onclick="showForm()"><i class="glyphicon glyphicon-plus"></i>Add Day</button>'+
                                '</div>'+
                            '</div>');
                    $('#plan-days').append('<div class="panel-default">'+
                        '<div class="panel-body">'+
                            '<div class="hidden" id="add-plan-day" >'+
                                '<div class="form-group">'+
                                  '<label for="dayName">Day</label>'+
                                  '<input type="text" class="form-control" id="day-name" placeholder="Enter day name" name="day-name">'+
                                '</div>'+
                                '<button class="btn btn-default" onclick="addDayToPlan('+planId+')">Add</button> '+
                                '<button class="btn btn-default" onclick="hideForm()">Cancel</button>'+
                            '</div>'+
                            '</div>'+
                            '</div>');
                }
                $('#plan-overview').removeClass('hidden');
                $('#plan-overview').focus();
           }
        });
    }

    function updatePlan(planId) {
        var newPlanName = $('#plan-name-'+planId).val();
        if(newPlanName.length !== 0) {
            $.ajax({
                type : "PUT",
                url : baseUrl+"/virtualgym/api/plan.php?action=updateplan&planid="+planId,
                data : {
                    planname : newPlanName
                },
                success : function(response,status,http) {
                    if(response.status == 200){
                        swal('Update Plan', response.status_message, 'success');
                        $('#plan-list-item-title-'+planId).html(newPlanName);
                        getUsers(); //update plan dropdown for users
                    } else if((response.status == 500) || (response.status == 400)) {
                        swal('Update Plan', response.status_message, 'error');    
                    }
                }
            });    
        } else {
            swal('Update Plan', 'Empty plan name', 'error');
        }
        
    }

    function addtoday(exerciseId) {
        var dayId;
        dayId = jQuery("#day-select-"+exerciseId+" option:selected").val();
        $.ajax({
            type :"POST",
            url : baseUrl+"/virtualgym/api/plan.php",
            data : {
                'action' : 'adddayexercise',
                'day_id' : dayId,
                'exercise_id' : exerciseId
            },           
            success: function(response,status,http) {
                var planId;
                planId = $('#plan-id-overview').val();
                if(response.status == 200){
                    swal('Add Exercise', response.status_message, 'success');
                    getPlanOverview(planId);
                } else if((response.status == 500) || (response.status == 400)) {
                    swal('Add Exercise', response.status_message, 'error');    
                }
                
           }
        });
    }

    function showForm() {
        $("#add-plan-day").removeClass('hidden');
    }
    function hideForm() {
        $("#add-plan-day").addClass('hidden');
    }

    function hidePlanOverview() {
        $('#plan-overview').addClass('hidden');        
    }

    function addDayToPlan(planId) {
        $(this).prop('disabled', true);
        var dayName = $('#day-name').val();
        var planId = $('#plan-id-overview').val();
        if(dayName.length == 0) {
            swal('Add Day', 'Empty day name', 'error');
        } else if(planId.length !== 0) {
            $.ajax({
                type :"POST",
                url : baseUrl+"/virtualgym/api/plan.php",
                data : {
                    'action' : 'addday',
                    'plan_id' : planId,
                    'day_name' : dayName
                },           
                success: function(response,status,http) {
                    if(response.status == 200){
                        swal('Add Day', response.status_message, 'success');
                        getPlanOverview(planId);
                    } else if((response.status == 500) || (response.status == 400)) {
                        swal('Add Day', response.status_message, 'error');    
                    }
                    
               }
            });
        }
    }

    function removeDay(dayId) {
        //day_dayId
        $.ajax({
            type : "DELETE",
            url : baseUrl+"/virtualgym/api/plan.php?action=deleteday&dayid="+dayId,
            success : function(response,status,http) {
                if(response.status == 200){
                    swal('Delete Day', response.status_message, 'success');
                    $('#day_'+dayId).remove();
                    $(".day-dropdown option[value='"+dayId+"']").remove();
                } else if((response.status == 500) || (response.status == 400)) {
                    swal('Delete Day', response.status_message, 'error');    
                }
            }
        });
    }

    function removePlan(planId) {
        $.ajax({
            type : "DELETE",
            url : baseUrl+"/virtualgym/api/plan.php?action=deleteplan&planid="+planId,
            success : function(response,status,http) {
                if(response.status == 200){
                    swal('Delete Plan', response.status_message, 'success');
                    $('#plan-list-item-'+planId).remove();
                } else if((response.status == 500) || (response.status == 400)) {
                    swal('Delete Plan', response.status_message, 'error');    
                }
            }
        });   
    }

    function removeExercise(exerciseId, dayId, planId) {
        $.ajax({
            type : "DELETE",
            url : baseUrl+"/virtualgym/api/plan.php?action=deletedayexercise&dayid="+dayId+'&exerciseid='+exerciseId,
            success : function(response,status,http) {
                if(response.status == 200){
                    swal('Remove Exercise', response.status_message, 'success');
                    getPlanDays(planId);
                } else if((response.status == 500) || (response.status == 400)) {
                    swal('Remove Exercise', response.status_message, 'error');    
                }
            }
        });
    }
    $(document).ready(function() {        
        getPlans();
        getUsers();
        getExercises('mainlist');
        getExercises('planlist');
        //getPlanOverview(2);

        
    });
    
</script>