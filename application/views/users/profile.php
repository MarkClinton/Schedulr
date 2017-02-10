
<div id="profile_background" ng-app="fetch">
    <div id="profile_contain">
        <div>
            <img class="profile" src="<?php echo base_url() ?>/assets/images/1HFMKW4.jpg" alt="profile" />
        </div>

        <div ng-controller="profileCtrl">
        <br>
        <table class="table table-striped table-hover ">
            <tbody ng-repeat="user in profile">
                <tr>
                    <td>Name:</td>
                    <td>{{user.FIRST_NAME}} {{user.LAST_NAME}}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>{{user.EMAIL}}</td>
                </tr>
            </tbody>
        </table> 
        </div>

    </div>

    <div id="profile_dash">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="false">Tasks</a></li>
            <li class=""><a href="#home" data-toggle="tab" aria-expanded="true">Edit Profile</a></li>
            <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">Friends</a></li>

        </ul>
    </div>

</div>

