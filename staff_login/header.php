<div class="header-wrapper">
<div class="header">

<div style="display: inline-block;">
    <img width="400px" src="image/banner-logo.gif" alt="Banner" / >
</div>

<div class="header-body">

<div style="float:left">
<table class="basic-transparent-table">
    <tr>
        <th>
            Date :
        </th>
    </tr>
    <tr>
        <td>
            <?php echo rearr_date(date('Y-m-d')); ?>
        </td>
    </tr>
</table>
</div>

<div style="float:right">
<table class="basic-transparent-table">
    <tr>
        <th colspan="2">
            Active Session
        </th>
    </tr>
    <tr>
        <td rowspan="2">
            <img height="50" width="50" src="image/user-session.gif"/>
        </td>
        <td>
            <?php echo ucwords($_SESSION['staff_username']); ?>
        </td>
    </tr>
    <tr>
        <td>
            <a href="logout.php">Log Out</a>
        </td>
    </tr>
</table>
</div>

<div style="clear:both"></div>

</div>

</div>
</div>