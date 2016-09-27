<?php

// Global variable for table object
$tbl_employee_leaveapplication = NULL;

//
// Table class for tbl_employee_leaveapplication
//
class ctbl_employee_leaveapplication extends cTable {
	var $leave_application_id;
	var $emp_id;
	var $leave_type_id;
	var $sickness;
	var $place_to_visit;
	var $days_to_leave;
	var $status_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_employee_leaveapplication';
		$this->TableName = 'tbl_employee_leaveapplication';
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

		// leave_application_id
		$this->leave_application_id = new cField('tbl_employee_leaveapplication', 'tbl_employee_leaveapplication', 'x_leave_application_id', 'leave_application_id', '`leave_application_id`', '`leave_application_id`', 3, -1, FALSE, '`leave_application_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->leave_application_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['leave_application_id'] = &$this->leave_application_id;

		// emp_id
		$this->emp_id = new cField('tbl_employee_leaveapplication', 'tbl_employee_leaveapplication', 'x_emp_id', 'emp_id', '`emp_id`', '`emp_id`', 3, -1, FALSE, '`emp_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->emp_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['emp_id'] = &$this->emp_id;

		// leave_type_id
		$this->leave_type_id = new cField('tbl_employee_leaveapplication', 'tbl_employee_leaveapplication', 'x_leave_type_id', 'leave_type_id', '`leave_type_id`', '`leave_type_id`', 3, -1, FALSE, '`leave_type_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->leave_type_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['leave_type_id'] = &$this->leave_type_id;

		// sickness
		$this->sickness = new cField('tbl_employee_leaveapplication', 'tbl_employee_leaveapplication', 'x_sickness', 'sickness', '`sickness`', '`sickness`', 200, -1, FALSE, '`sickness`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['sickness'] = &$this->sickness;

		// place_to_visit
		$this->place_to_visit = new cField('tbl_employee_leaveapplication', 'tbl_employee_leaveapplication', 'x_place_to_visit', 'place_to_visit', '`place_to_visit`', '`place_to_visit`', 200, -1, FALSE, '`place_to_visit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['place_to_visit'] = &$this->place_to_visit;

		// days_to_leave
		$this->days_to_leave = new cField('tbl_employee_leaveapplication', 'tbl_employee_leaveapplication', 'x_days_to_leave', 'days_to_leave', '`days_to_leave`', '`days_to_leave`', 3, -1, FALSE, '`days_to_leave`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->days_to_leave->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['days_to_leave'] = &$this->days_to_leave;

		// status_id
		$this->status_id = new cField('tbl_employee_leaveapplication', 'tbl_employee_leaveapplication', 'x_status_id', 'status_id', '`status_id`', '`status_id`', 3, -1, FALSE, '`status_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->status_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status_id'] = &$this->status_id;
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
		if ($this->getCurrentDetailTable() == "tbl_leavecoverage") {
			$sDetailUrl = $GLOBALS["tbl_leavecoverage"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&leave_application_id=" . $this->leave_application_id->CurrentValue;
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "tbl_employee_leaveapplicationlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`tbl_employee_leaveapplication`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		// $sWhere = "";
		// $this->TableFilter = "";
		// ew_AddFilter($sWhere, $this->TableFilter);
		// return $sWhere;
		
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
	var $UpdateTable = "`tbl_employee_leaveapplication`";

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
			if (array_key_exists('leave_application_id', $rs))
				ew_AddFilter($where, ew_QuotedName('leave_application_id') . '=' . ew_QuotedValue($rs['leave_application_id'], $this->leave_application_id->FldDataType));
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
		return "`leave_application_id` = @leave_application_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->leave_application_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@leave_application_id@", ew_AdjustSql($this->leave_application_id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "tbl_employee_leaveapplicationlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_employee_leaveapplicationlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("tbl_employee_leaveapplicationview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("tbl_employee_leaveapplicationview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_employee_leaveapplicationadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("tbl_employee_leaveapplicationedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("tbl_employee_leaveapplicationedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("tbl_employee_leaveapplicationadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("tbl_employee_leaveapplicationadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_employee_leaveapplicationdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->leave_application_id->CurrentValue)) {
			$sUrl .= "leave_application_id=" . urlencode($this->leave_application_id->CurrentValue);
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
			$arKeys[] = @$_GET["leave_application_id"]; // leave_application_id

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
			$this->leave_application_id->CurrentValue = $key;
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
		$this->leave_application_id->setDbValue($rs->fields('leave_application_id'));
		$this->emp_id->setDbValue($rs->fields('emp_id'));
		$this->leave_type_id->setDbValue($rs->fields('leave_type_id'));
		$this->sickness->setDbValue($rs->fields('sickness'));
		$this->place_to_visit->setDbValue($rs->fields('place_to_visit'));
		$this->days_to_leave->setDbValue($rs->fields('days_to_leave'));
		$this->status_id->setDbValue($rs->fields('status_id'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// leave_application_id
		// emp_id
		// leave_type_id
		// sickness
		// place_to_visit
		// days_to_leave
		// status_id
		// leave_application_id

		$this->leave_application_id->ViewValue = $this->leave_application_id->CurrentValue;
		$this->leave_application_id->ViewCustomAttributes = "";

		// emp_id
		$this->emp_id->ViewValue = $this->emp_id->CurrentValue;
		if (strval($this->emp_id->CurrentValue) <> "") {
			$sFilterWrk = "`emp_id`" . ew_SearchString("=", $this->emp_id->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `emp_id`, `empLastName` AS `DispFld`, `empFirstName` AS `Disp2Fld`, `empMiddleName` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_employee`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->emp_id, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->emp_id->ViewValue = $rswrk->fields('DispFld');
				$this->emp_id->ViewValue .= ew_ValueSeparator(1,$this->emp_id) . $rswrk->fields('Disp2Fld');
				$this->emp_id->ViewValue .= ew_ValueSeparator(2,$this->emp_id) . $rswrk->fields('Disp3Fld');
				$rswrk->Close();
			} else {
				$this->emp_id->ViewValue = $this->emp_id->CurrentValue;
			}
		} else {
			$this->emp_id->ViewValue = NULL;
		}
		$this->emp_id->ViewCustomAttributes = "";

		// leave_type_id
		if (strval($this->leave_type_id->CurrentValue) <> "") {
			$sFilterWrk = "`leave_type_id`" . ew_SearchString("=", $this->leave_type_id->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `leave_type_id`, `leave_type_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_leave`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->leave_type_id, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->leave_type_id->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->leave_type_id->ViewValue = $this->leave_type_id->CurrentValue;
			}
		} else {
			$this->leave_type_id->ViewValue = NULL;
		}
		$this->leave_type_id->ViewCustomAttributes = "";

		// sickness
		$this->sickness->ViewValue = $this->sickness->CurrentValue;
		$this->sickness->ViewCustomAttributes = "";

		// place_to_visit
		$this->place_to_visit->ViewValue = $this->place_to_visit->CurrentValue;
		$this->place_to_visit->ViewCustomAttributes = "";

		// days_to_leave
		$this->days_to_leave->ViewValue = $this->days_to_leave->CurrentValue;
		$this->days_to_leave->ViewCustomAttributes = "";

		// status_id
		if (strval($this->status_id->CurrentValue) <> "") {
			$sFilterWrk = "`status_id`" . ew_SearchString("=", $this->status_id->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `status_id`, `status_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_status`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->status_id, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->status_id->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->status_id->ViewValue = $this->status_id->CurrentValue;
			}
		} else {
			$this->status_id->ViewValue = NULL;
		}
		$this->status_id->ViewCustomAttributes = "";

		// leave_application_id
		$this->leave_application_id->LinkCustomAttributes = "";
		$this->leave_application_id->HrefValue = "";
		$this->leave_application_id->TooltipValue = "";

		// emp_id
		$this->emp_id->LinkCustomAttributes = "";
		$this->emp_id->HrefValue = "";
		$this->emp_id->TooltipValue = "";

		// leave_type_id
		$this->leave_type_id->LinkCustomAttributes = "";
		$this->leave_type_id->HrefValue = "";
		$this->leave_type_id->TooltipValue = "";

		// sickness
		$this->sickness->LinkCustomAttributes = "";
		$this->sickness->HrefValue = "";
		$this->sickness->TooltipValue = "";

		// place_to_visit
		$this->place_to_visit->LinkCustomAttributes = "";
		$this->place_to_visit->HrefValue = "";
		$this->place_to_visit->TooltipValue = "";

		// days_to_leave
		$this->days_to_leave->LinkCustomAttributes = "";
		$this->days_to_leave->HrefValue = "";
		$this->days_to_leave->TooltipValue = "";

		// status_id
		$this->status_id->LinkCustomAttributes = "";
		$this->status_id->HrefValue = "";
		$this->status_id->TooltipValue = "";

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
				if ($this->leave_application_id->Exportable) $Doc->ExportCaption($this->leave_application_id);
				if ($this->emp_id->Exportable) $Doc->ExportCaption($this->emp_id);
				if ($this->leave_type_id->Exportable) $Doc->ExportCaption($this->leave_type_id);
				if ($this->sickness->Exportable) $Doc->ExportCaption($this->sickness);
				if ($this->place_to_visit->Exportable) $Doc->ExportCaption($this->place_to_visit);
				if ($this->days_to_leave->Exportable) $Doc->ExportCaption($this->days_to_leave);
				if ($this->status_id->Exportable) $Doc->ExportCaption($this->status_id);
			} else {
				if ($this->leave_application_id->Exportable) $Doc->ExportCaption($this->leave_application_id);
				if ($this->emp_id->Exportable) $Doc->ExportCaption($this->emp_id);
				if ($this->leave_type_id->Exportable) $Doc->ExportCaption($this->leave_type_id);
				if ($this->sickness->Exportable) $Doc->ExportCaption($this->sickness);
				if ($this->place_to_visit->Exportable) $Doc->ExportCaption($this->place_to_visit);
				if ($this->days_to_leave->Exportable) $Doc->ExportCaption($this->days_to_leave);
				if ($this->status_id->Exportable) $Doc->ExportCaption($this->status_id);
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
					if ($this->leave_application_id->Exportable) $Doc->ExportField($this->leave_application_id);
					if ($this->emp_id->Exportable) $Doc->ExportField($this->emp_id);
					if ($this->leave_type_id->Exportable) $Doc->ExportField($this->leave_type_id);
					if ($this->sickness->Exportable) $Doc->ExportField($this->sickness);
					if ($this->place_to_visit->Exportable) $Doc->ExportField($this->place_to_visit);
					if ($this->days_to_leave->Exportable) $Doc->ExportField($this->days_to_leave);
					if ($this->status_id->Exportable) $Doc->ExportField($this->status_id);
				} else {
					if ($this->leave_application_id->Exportable) $Doc->ExportField($this->leave_application_id);
					if ($this->emp_id->Exportable) $Doc->ExportField($this->emp_id);
					if ($this->leave_type_id->Exportable) $Doc->ExportField($this->leave_type_id);
					if ($this->sickness->Exportable) $Doc->ExportField($this->sickness);
					if ($this->place_to_visit->Exportable) $Doc->ExportField($this->place_to_visit);
					if ($this->days_to_leave->Exportable) $Doc->ExportField($this->days_to_leave);
					if ($this->status_id->Exportable) $Doc->ExportField($this->status_id);
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
