<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(18, $Language->MenuPhrase("18", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(7, $Language->MenuPhrase("7", "MenuText"), "tbl_employeelist.php", 18, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_employee'), FALSE);
$RootMenu->AddMenuItem(8, $Language->MenuPhrase("8", "MenuText"), "tbl_employee_deductionlist.php?cmd=resetall", 18, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_employee_deduction'), FALSE);
$RootMenu->AddMenuItem(9, $Language->MenuPhrase("9", "MenuText"), "tbl_employee_leavecreditlist.php?cmd=resetall", 18, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_employee_leavecredit'), FALSE);
$RootMenu->AddMenuItem(10, $Language->MenuPhrase("10", "MenuText"), "tbl_employee_timeloglist.php", 18, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_employee_timelog'), FALSE);
$RootMenu->AddMenuItem(19, $Language->MenuPhrase("19", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(1, $Language->MenuPhrase("1", "MenuText"), "lib_deductionlist.php", 19, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_deduction'), FALSE);
$RootMenu->AddMenuItem(2, $Language->MenuPhrase("2", "MenuText"), "lib_leavelist.php", 19, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_leave'), FALSE);
$RootMenu->AddMenuItem(3, $Language->MenuPhrase("3", "MenuText"), "lib_salarylist.php", 19, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_salary'), FALSE);
$RootMenu->AddMenuItem(4, $Language->MenuPhrase("4", "MenuText"), "lib_schedulelist.php", 19, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_schedule'), FALSE);
$RootMenu->AddMenuItem(5, $Language->MenuPhrase("5", "MenuText"), "lib_sexlist.php", 19, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_sex'), FALSE);
$RootMenu->AddMenuItem(6, $Language->MenuPhrase("6", "MenuText"), "lib_tax_categorylist.php", 19, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_tax_category'), FALSE);
$RootMenu->AddMenuItem(20, $Language->MenuPhrase("20", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(14, $Language->MenuPhrase("14", "MenuText"), "tbl_userlist.php", 20, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_user'), FALSE);
$RootMenu->AddMenuItem(13, $Language->MenuPhrase("13", "MenuText"), "audittraillist.php", 20, "", AllowListMenu('{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}audittrail'), FALSE);
$RootMenu->AddMenuItem(16, $Language->MenuPhrase("16", "MenuText"), "userlevelslist.php", 20, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE);
$RootMenu->AddMenuItem(15, $Language->MenuPhrase("15", "MenuText"), "userlevelpermissionslist.php", 20, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE);
$RootMenu->AddMenuItem(-2, $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
