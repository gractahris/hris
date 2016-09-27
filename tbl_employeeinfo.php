<?php

// Global variable for table object
$tbl_employee = NULL;

//
// Table class for tbl_employee
//
class ctbl_employee extends cTable {
	var $emp_id;
	var $empFirstName;
	var $empMiddleName;
	var $empLastName;
	var $empExtensionName;
	var $sex_id;
	var $schedule_id;
	var $salary_id;
	var $tax_category_id;
	var $date_hired;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_employee';
		$this->TableName = 'tbl_employee';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// emp_id
		$this->emp_id = new cField('tbl_employee', 'tbl_employee', 'x_emp_id', 'emp_id', '`emp_id`', '`emp_id`', 3, -1, FALSE, '`emp_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->emp_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['emp_id'] = &$this->emp_id;

		// empFirstName
		$this->empFirstName = new cField('tbl_employee', 'tbl_employee', 'x_empFirstName', 'empFirstName', '`empFirstName`', '`empFirstName`', 200, -1, FALSE, '`empFirstName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['empFirstName'] = &$this->empFirstName;

		// empMiddleName
		$this->empMiddleName = new cField('tbl_employee', 'tbl_employee', 'x_empMiddleName', 'empMiddleName', '`empMiddleName`', '`empMiddleName`', 200, -1, FALSE, '`empMiddleName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['empMiddleName'] = &$this->empMiddleName;

		// empLastName
		$this->empLastName = new cField('tbl_employee', 'tbl_employee', 'x_empLastName', 'empLastName', '`empLastName`', '`empLastName`', 200, -1, FALSE, '`empLastName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['empLastName'] = &$this->empLastName;

		// empExtensionName
		$this->empExtensionName = new cField('tbl_employee', 'tbl_employee', 'x_empExtensionName', 'empExtensionName', '`empExtensionName`', '`empExtensionName`', 200, -1, FALSE, '`empExtensionName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['empExtensionName'] = &$this->empExtensionName;

		// sex_id
		$this->sex_id = new cField('tbl_employee', 'tbl_employee', 'x_sex_id', 'sex_id', '`sex_id`', '`sex_id`', 3, -1, FALSE, '`sex_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->sex_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sex_id'] = &$this->sex_id;

		// schedule_id
		$this->schedule_id = new cField('tbl_employee', 'tbl_employee', 'x_schedule_id', 'schedule_id', '`schedule_id`', '`schedule_id`', 3, -1, FALSE, '`schedule_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->schedule_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['schedule_id'] = &$this->schedule_id;

		// salary_id
		$this->salary_id = new cField('tbl_employee', 'tbl_employee', 'x_salary_id', 'salary_id', '`salary_id`', '`salary_id`', 3, -1, FALSE, '`salary_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->salary_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['salary_id'] = &$this->salary_id;

		// tax_category_id
		$this->tax_category_id = new cField('tbl_employee', 'tbl_employee', 'x_tax_category_id', 'tax_category_id', '`tax_category_id`', '`tax_category_id`', 3, -1, FALSE, '`tax_category_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->tax_category_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tax_category_id'] = &$this->tax_category_id;

		// date_hired
		$this->date_hired = new cField('tbl_employee', 'tbl_employee', 'x_date_hired', 'date_hired', '`date_hired`', 'DATE_FORMAT(`date_hired`, \'%Y/%m/%d\')', 135, 5, FALSE, '`date_hired`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->date_hired->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['date_hired'] = &$this->date_hired;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "tbl_employee_deduction") {
			$sDetailUrl = $GLOBALS["tbl_employee_deduction"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&emp_id=" . $this->emp_id->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "tbl_employee_leavecredit") {
			$sDetailUrl = $GLOBALS["tbl_employee_leavecredit"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&emp_id=" . $this->emp_id->CurrentValue;
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "tbl_employeelist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`tbl_employee`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		if (CurrentUserLevel() == "2")
		{
			$sWhere = "emp_id='".$_SESSION['emp_id']."'";
			$this->TableFilter = "";
			ew_AddFilter($sWhere, $this->TableFilter);
			return $sWhere;
		}
		
		else
		{
			$sWhere = "";
			$this->TableFilter = "";
			ew_AddFilter($sWhere, $this->TableFilter);
			return $sWhere;
			
		}
	}
	
	// function SqlWhere($emp_id) { // Where
		// $sWhere = "emp_id=".$emp_id;
		// $this->TableFilter = "";
		// ew_AddFilter($sWhere, $this->TableFilter);
		// return $sWhere;
	// }

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`tbl_employee`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL) {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			if (array_key_exists('emp_id', $rs))
				ew_AddFilter($where, ew_QuotedName('emp_id') . '=' . ew_QuotedValue($rs['emp_id'], $this->emp_id->FldDataType));
		}
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`emp_id` = @emp_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->emp_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@emp_id@", ew_AdjustSql($this->emp_id->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "tbl_employeelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_employeelist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("tbl_employeeview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("tbl_employeeview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_employeeadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("tbl_employeeedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("tbl_employeeedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("tbl_employeeadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("tbl_employeeadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_employeedelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->emp_id->CurrentValue)) {
			$sUrl .= "emp_id=" . urlencode($this->emp_id->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["emp_id"]; // emp_id

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->emp_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->emp_id->setDbValue($rs->fields('emp_id'));
		$this->empFirstName->setDbValue($rs->fields('empFirstName'));
		$this->empMiddleName->setDbValue($rs->fields('empMiddleName'));
		$this->empLastName->setDbValue($rs->fields('empLastName'));
		$this->empExtensionName->setDbValue($rs->fields('empExtensionName'));
		$this->sex_id->setDbValue($rs->fields('sex_id'));
		$this->schedule_id->setDbValue($rs->fields('schedule_id'));
		$this->salary_id->setDbValue($rs->fields('salary_id'));
		$this->tax_category_id->setDbValue($rs->fields('tax_category_id'));
		$this->date_hired->setDbValue($rs->fields('date_hired'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// emp_id
		// empFirstName
		// empMiddleName
		// empLastName
		// empExtensionName
		// sex_id
		// schedule_id
		// salary_id
		// tax_category_id
		// date_hired
		// emp_id

		$this->emp_id->ViewValue = $this->emp_id->CurrentValue;
		$this->emp_id->ViewCustomAttributes = "";

		// empFirstName
		$this->empFirstName->ViewValue = $this->empFirstName->CurrentValue;
		$this->empFirstName->ViewCustomAttributes = "";

		// empMiddleName
		$this->empMiddleName->ViewValue = $this->empMiddleName->CurrentValue;
		$this->empMiddleName->ViewCustomAttributes = "";

		// empLastName
		$this->empLastName->ViewValue = $this->empLastName->CurrentValue;
		$this->empLastName->ViewCustomAttributes = "";

		// empExtensionName
		$this->empExtensionName->ViewValue = $this->empExtensionName->CurrentValue;
		$this->empExtensionName->ViewCustomAttributes = "";

		// sex_id
		if (strval($this->sex_id->CurrentValue) <> "") {
			$sFilterWrk = "`sex_id`" . ew_SearchString("=", $this->sex_id->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `sex_id`, `sex_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_sex`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->sex_id, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->sex_id->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->sex_id->ViewValue = $this->sex_id->CurrentValue;
			}
		} else {
			$this->sex_id->ViewValue = NULL;
		}
		$this->sex_id->ViewCustomAttributes = "";

		// schedule_id
		if (strval($this->schedule_id->CurrentValue) <> "") {
			$sFilterWrk = "`schedule_id`" . ew_SearchString("=", $this->schedule_id->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `schedule_id`, `schedule_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_schedule`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->schedule_id, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->schedule_id->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->schedule_id->ViewValue = $this->schedule_id->CurrentValue;
			}
		} else {
			$this->schedule_id->ViewValue = NULL;
		}
		$this->schedule_id->ViewCustomAttributes = "";

		// salary_id
		if (strval($this->salary_id->CurrentValue) <> "") {
			$sFilterWrk = "`salary_id`" . ew_SearchString("=", $this->salary_id->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `salary_id`, `salary_amount` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_salary`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->salary_id, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->salary_id->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->salary_id->ViewValue = $this->salary_id->CurrentValue;
			}
		} else {
			$this->salary_id->ViewValue = NULL;
		}
		$this->salary_id->ViewCustomAttributes = "";

		// tax_category_id
		if (strval($this->tax_category_id->CurrentValue) <> "") {
			$sFilterWrk = "`tax_category_id`" . ew_SearchString("=", $this->tax_category_id->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `tax_category_id`, `tax_category_code` AS `DispFld`, `tax_category_title` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_tax_category`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->tax_category_id, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->tax_category_id->ViewValue = $rswrk->fields('DispFld');
				$this->tax_category_id->ViewValue .= ew_ValueSeparator(1,$this->tax_category_id) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->tax_category_id->ViewValue = $this->tax_category_id->CurrentValue;
			}
		} else {
			$this->tax_category_id->ViewValue = NULL;
		}
		$this->tax_category_id->ViewCustomAttributes = "";

		// date_hired
		$this->date_hired->ViewValue = $this->date_hired->CurrentValue;
		$this->date_hired->ViewValue = ew_FormatDateTime($this->date_hired->ViewValue, 5);
		$this->date_hired->ViewCustomAttributes = "";

		// emp_id
		$this->emp_id->LinkCustomAttributes = "";
		$this->emp_id->HrefValue = "";
		$this->emp_id->TooltipValue = "";

		// empFirstName
		$this->empFirstName->LinkCustomAttributes = "";
		$this->empFirstName->HrefValue = "";
		$this->empFirstName->TooltipValue = "";

		// empMiddleName
		$this->empMiddleName->LinkCustomAttributes = "";
		$this->empMiddleName->HrefValue = "";
		$this->empMiddleName->TooltipValue = "";

		// empLastName
		$this->empLastName->LinkCustomAttributes = "";
		$this->empLastName->HrefValue = "";
		$this->empLastName->TooltipValue = "";

		// empExtensionName
		$this->empExtensionName->LinkCustomAttributes = "";
		$this->empExtensionName->HrefValue = "";
		$this->empExtensionName->TooltipValue = "";

		// sex_id
		$this->sex_id->LinkCustomAttributes = "";
		$this->sex_id->HrefValue = "";
		$this->sex_id->TooltipValue = "";

		// schedule_id
		$this->schedule_id->LinkCustomAttributes = "";
		$this->schedule_id->HrefValue = "";
		$this->schedule_id->TooltipValue = "";

		// salary_id
		$this->salary_id->LinkCustomAttributes = "";
		$this->salary_id->HrefValue = "";
		$this->salary_id->TooltipValue = "";

		// tax_category_id
		$this->tax_category_id->LinkCustomAttributes = "";
		$this->tax_category_id->HrefValue = "";
		$this->tax_category_id->TooltipValue = "";

		// date_hired
		$this->date_hired->LinkCustomAttributes = "";
		$this->date_hired->HrefValue = "";
		$this->date_hired->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
				if ($this->emp_id->Exportable) $Doc->ExportCaption($this->emp_id);
				if ($this->empFirstName->Exportable) $Doc->ExportCaption($this->empFirstName);
				if ($this->empMiddleName->Exportable) $Doc->ExportCaption($this->empMiddleName);
				if ($this->empLastName->Exportable) $Doc->ExportCaption($this->empLastName);
				if ($this->empExtensionName->Exportable) $Doc->ExportCaption($this->empExtensionName);
				if ($this->sex_id->Exportable) $Doc->ExportCaption($this->sex_id);
				if ($this->schedule_id->Exportable) $Doc->ExportCaption($this->schedule_id);
				if ($this->salary_id->Exportable) $Doc->ExportCaption($this->salary_id);
				if ($this->tax_category_id->Exportable) $Doc->ExportCaption($this->tax_category_id);
				if ($this->date_hired->Exportable) $Doc->ExportCaption($this->date_hired);
			} else {
				if ($this->emp_id->Exportable) $Doc->ExportCaption($this->emp_id);
				if ($this->empFirstName->Exportable) $Doc->ExportCaption($this->empFirstName);
				if ($this->empMiddleName->Exportable) $Doc->ExportCaption($this->empMiddleName);
				if ($this->empLastName->Exportable) $Doc->ExportCaption($this->empLastName);
				if ($this->empExtensionName->Exportable) $Doc->ExportCaption($this->empExtensionName);
				if ($this->sex_id->Exportable) $Doc->ExportCaption($this->sex_id);
				if ($this->schedule_id->Exportable) $Doc->ExportCaption($this->schedule_id);
				if ($this->salary_id->Exportable) $Doc->ExportCaption($this->salary_id);
				if ($this->tax_category_id->Exportable) $Doc->ExportCaption($this->tax_category_id);
				if ($this->date_hired->Exportable) $Doc->ExportCaption($this->date_hired);
			}
			$Doc->EndExportRow();
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					if ($this->emp_id->Exportable) $Doc->ExportField($this->emp_id);
					if ($this->empFirstName->Exportable) $Doc->ExportField($this->empFirstName);
					if ($this->empMiddleName->Exportable) $Doc->ExportField($this->empMiddleName);
					if ($this->empLastName->Exportable) $Doc->ExportField($this->empLastName);
					if ($this->empExtensionName->Exportable) $Doc->ExportField($this->empExtensionName);
					if ($this->sex_id->Exportable) $Doc->ExportField($this->sex_id);
					if ($this->schedule_id->Exportable) $Doc->ExportField($this->schedule_id);
					if ($this->salary_id->Exportable) $Doc->ExportField($this->salary_id);
					if ($this->tax_category_id->Exportable) $Doc->ExportField($this->tax_category_id);
					if ($this->date_hired->Exportable) $Doc->ExportField($this->date_hired);
				} else {
					if ($this->emp_id->Exportable) $Doc->ExportField($this->emp_id);
					if ($this->empFirstName->Exportable) $Doc->ExportField($this->empFirstName);
					if ($this->empMiddleName->Exportable) $Doc->ExportField($this->empMiddleName);
					if ($this->empLastName->Exportable) $Doc->ExportField($this->empLastName);
					if ($this->empExtensionName->Exportable) $Doc->ExportField($this->empExtensionName);
					if ($this->sex_id->Exportable) $Doc->ExportField($this->sex_id);
					if ($this->schedule_id->Exportable) $Doc->ExportField($this->schedule_id);
					if ($this->salary_id->Exportable) $Doc->ExportField($this->salary_id);
					if ($this->tax_category_id->Exportable) $Doc->ExportField($this->tax_category_id);
					if ($this->date_hired->Exportable) $Doc->ExportField($this->date_hired);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
