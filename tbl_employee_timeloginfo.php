<?php

// Global variable for table object
$tbl_employee_timelog = NULL;

//
// Table class for tbl_employee_timelog
//
class ctbl_employee_timelog extends cTable {
	var $ref_id;
	var $emp_id;
	var $emp_datelog;
	var $emp_timein;
	var $emp_timeout;
	var $emp_totalhours;
	var $emp_late;
	var $emp_excesstime;
	var $emp_undertime;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_employee_timelog';
		$this->TableName = 'tbl_employee_timelog';
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

		// ref_id
		$this->ref_id = new cField('tbl_employee_timelog', 'tbl_employee_timelog', 'x_ref_id', 'ref_id', '`ref_id`', '`ref_id`', 3, -1, FALSE, '`ref_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->ref_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ref_id'] = &$this->ref_id;

		// emp_id
		$this->emp_id = new cField('tbl_employee_timelog', 'tbl_employee_timelog', 'x_emp_id', 'emp_id', '`emp_id`', '`emp_id`', 3, -1, FALSE, '`emp_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->emp_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['emp_id'] = &$this->emp_id;

		// emp_datelog
		$this->emp_datelog = new cField('tbl_employee_timelog', 'tbl_employee_timelog', 'x_emp_datelog', 'emp_datelog', '`emp_datelog`', 'DATE_FORMAT(`emp_datelog`, \'%Y/%m/%d\')', 133, 5, FALSE, '`emp_datelog`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->emp_datelog->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['emp_datelog'] = &$this->emp_datelog;

		// emp_timein
		$this->emp_timein = new cField('tbl_employee_timelog', 'tbl_employee_timelog', 'x_emp_timein', 'emp_timein', '`emp_timein`', 'DATE_FORMAT(`emp_timein`, \'%Y/%m/%d\')', 134, -1, FALSE, '`emp_timein`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->emp_timein->FldDefaultErrMsg = $Language->Phrase("IncorrectTime");
		$this->fields['emp_timein'] = &$this->emp_timein;

		// emp_timeout
		$this->emp_timeout = new cField('tbl_employee_timelog', 'tbl_employee_timelog', 'x_emp_timeout', 'emp_timeout', '`emp_timeout`', 'DATE_FORMAT(`emp_timeout`, \'%Y/%m/%d\')', 134, -1, FALSE, '`emp_timeout`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->emp_timeout->FldDefaultErrMsg = $Language->Phrase("IncorrectTime");
		$this->fields['emp_timeout'] = &$this->emp_timeout;

		// emp_totalhours
		$this->emp_totalhours = new cField('tbl_employee_timelog', 'tbl_employee_timelog', 'x_emp_totalhours', 'emp_totalhours', '`emp_totalhours`', '`emp_totalhours`', 200, -1, FALSE, '`emp_totalhours`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['emp_totalhours'] = &$this->emp_totalhours;

		// emp_late
		$this->emp_late = new cField('tbl_employee_timelog', 'tbl_employee_timelog', 'x_emp_late', 'emp_late', '`emp_late`', '`emp_late`', 200, -1, FALSE, '`emp_late`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['emp_late'] = &$this->emp_late;

		// emp_excesstime
		$this->emp_excesstime = new cField('tbl_employee_timelog', 'tbl_employee_timelog', 'x_emp_excesstime', 'emp_excesstime', '`emp_excesstime`', '`emp_excesstime`', 200, -1, FALSE, '`emp_excesstime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['emp_excesstime'] = &$this->emp_excesstime;

		// emp_undertime
		$this->emp_undertime = new cField('tbl_employee_timelog', 'tbl_employee_timelog', 'x_emp_undertime', 'emp_undertime', '`emp_undertime`', '`emp_undertime`', 200, -1, FALSE, '`emp_undertime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['emp_undertime'] = &$this->emp_undertime;
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

	// Table level SQL
	function SqlFrom() { // From
		return "`tbl_employee_timelog`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
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
	var $UpdateTable = "`tbl_employee_timelog`";

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
			if (array_key_exists('ref_id', $rs))
				ew_AddFilter($where, ew_QuotedName('ref_id') . '=' . ew_QuotedValue($rs['ref_id'], $this->ref_id->FldDataType));
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
		return "`ref_id` = @ref_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->ref_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@ref_id@", ew_AdjustSql($this->ref_id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "tbl_employee_timeloglist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_employee_timeloglist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("tbl_employee_timelogview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("tbl_employee_timelogview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_employee_timelogadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("tbl_employee_timelogedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("tbl_employee_timelogadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_employee_timelogdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->ref_id->CurrentValue)) {
			$sUrl .= "ref_id=" . urlencode($this->ref_id->CurrentValue);
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
			$arKeys[] = @$_GET["ref_id"]; // ref_id

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
			$this->ref_id->CurrentValue = $key;
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
		$this->ref_id->setDbValue($rs->fields('ref_id'));
		$this->emp_id->setDbValue($rs->fields('emp_id'));
		$this->emp_datelog->setDbValue($rs->fields('emp_datelog'));
		$this->emp_timein->setDbValue($rs->fields('emp_timein'));
		$this->emp_timeout->setDbValue($rs->fields('emp_timeout'));
		$this->emp_totalhours->setDbValue($rs->fields('emp_totalhours'));
		$this->emp_late->setDbValue($rs->fields('emp_late'));
		$this->emp_excesstime->setDbValue($rs->fields('emp_excesstime'));
		$this->emp_undertime->setDbValue($rs->fields('emp_undertime'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// ref_id
		// emp_id
		// emp_datelog
		// emp_timein
		// emp_timeout
		// emp_totalhours
		// emp_late
		// emp_excesstime
		// emp_undertime
		// ref_id

		$this->ref_id->ViewValue = $this->ref_id->CurrentValue;
		$this->ref_id->ViewCustomAttributes = "";

		// emp_id
		$this->emp_id->ViewValue = $this->emp_id->CurrentValue;
		$this->emp_id->ViewCustomAttributes = "";

		// emp_datelog
		$this->emp_datelog->ViewValue = $this->emp_datelog->CurrentValue;
		$this->emp_datelog->ViewValue = ew_FormatDateTime($this->emp_datelog->ViewValue, 5);
		$this->emp_datelog->ViewCustomAttributes = "";

		// emp_timein
		$this->emp_timein->ViewValue = $this->emp_timein->CurrentValue;
		$this->emp_timein->ViewCustomAttributes = "";

		// emp_timeout
		$this->emp_timeout->ViewValue = $this->emp_timeout->CurrentValue;
		$this->emp_timeout->ViewCustomAttributes = "";

		// emp_totalhours
		$this->emp_totalhours->ViewValue = $this->emp_totalhours->CurrentValue;
		$this->emp_totalhours->ViewCustomAttributes = "";

		// emp_late
		$this->emp_late->ViewValue = $this->emp_late->CurrentValue;
		$this->emp_late->ViewCustomAttributes = "";

		// emp_excesstime
		$this->emp_excesstime->ViewValue = $this->emp_excesstime->CurrentValue;
		$this->emp_excesstime->ViewCustomAttributes = "";

		// emp_undertime
		$this->emp_undertime->ViewValue = $this->emp_undertime->CurrentValue;
		$this->emp_undertime->ViewCustomAttributes = "";

		// ref_id
		$this->ref_id->LinkCustomAttributes = "";
		$this->ref_id->HrefValue = "";
		$this->ref_id->TooltipValue = "";

		// emp_id
		$this->emp_id->LinkCustomAttributes = "";
		$this->emp_id->HrefValue = "";
		$this->emp_id->TooltipValue = "";

		// emp_datelog
		$this->emp_datelog->LinkCustomAttributes = "";
		$this->emp_datelog->HrefValue = "";
		$this->emp_datelog->TooltipValue = "";

		// emp_timein
		$this->emp_timein->LinkCustomAttributes = "";
		$this->emp_timein->HrefValue = "";
		$this->emp_timein->TooltipValue = "";

		// emp_timeout
		$this->emp_timeout->LinkCustomAttributes = "";
		$this->emp_timeout->HrefValue = "";
		$this->emp_timeout->TooltipValue = "";

		// emp_totalhours
		$this->emp_totalhours->LinkCustomAttributes = "";
		$this->emp_totalhours->HrefValue = "";
		$this->emp_totalhours->TooltipValue = "";

		// emp_late
		$this->emp_late->LinkCustomAttributes = "";
		$this->emp_late->HrefValue = "";
		$this->emp_late->TooltipValue = "";

		// emp_excesstime
		$this->emp_excesstime->LinkCustomAttributes = "";
		$this->emp_excesstime->HrefValue = "";
		$this->emp_excesstime->TooltipValue = "";

		// emp_undertime
		$this->emp_undertime->LinkCustomAttributes = "";
		$this->emp_undertime->HrefValue = "";
		$this->emp_undertime->TooltipValue = "";

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
				if ($this->ref_id->Exportable) $Doc->ExportCaption($this->ref_id);
				if ($this->emp_id->Exportable) $Doc->ExportCaption($this->emp_id);
				if ($this->emp_datelog->Exportable) $Doc->ExportCaption($this->emp_datelog);
				if ($this->emp_timein->Exportable) $Doc->ExportCaption($this->emp_timein);
				if ($this->emp_timeout->Exportable) $Doc->ExportCaption($this->emp_timeout);
				if ($this->emp_totalhours->Exportable) $Doc->ExportCaption($this->emp_totalhours);
				if ($this->emp_late->Exportable) $Doc->ExportCaption($this->emp_late);
				if ($this->emp_excesstime->Exportable) $Doc->ExportCaption($this->emp_excesstime);
				if ($this->emp_undertime->Exportable) $Doc->ExportCaption($this->emp_undertime);
			} else {
				if ($this->ref_id->Exportable) $Doc->ExportCaption($this->ref_id);
				if ($this->emp_id->Exportable) $Doc->ExportCaption($this->emp_id);
				if ($this->emp_datelog->Exportable) $Doc->ExportCaption($this->emp_datelog);
				if ($this->emp_timein->Exportable) $Doc->ExportCaption($this->emp_timein);
				if ($this->emp_timeout->Exportable) $Doc->ExportCaption($this->emp_timeout);
				if ($this->emp_totalhours->Exportable) $Doc->ExportCaption($this->emp_totalhours);
				if ($this->emp_late->Exportable) $Doc->ExportCaption($this->emp_late);
				if ($this->emp_excesstime->Exportable) $Doc->ExportCaption($this->emp_excesstime);
				if ($this->emp_undertime->Exportable) $Doc->ExportCaption($this->emp_undertime);
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
					if ($this->ref_id->Exportable) $Doc->ExportField($this->ref_id);
					if ($this->emp_id->Exportable) $Doc->ExportField($this->emp_id);
					if ($this->emp_datelog->Exportable) $Doc->ExportField($this->emp_datelog);
					if ($this->emp_timein->Exportable) $Doc->ExportField($this->emp_timein);
					if ($this->emp_timeout->Exportable) $Doc->ExportField($this->emp_timeout);
					if ($this->emp_totalhours->Exportable) $Doc->ExportField($this->emp_totalhours);
					if ($this->emp_late->Exportable) $Doc->ExportField($this->emp_late);
					if ($this->emp_excesstime->Exportable) $Doc->ExportField($this->emp_excesstime);
					if ($this->emp_undertime->Exportable) $Doc->ExportField($this->emp_undertime);
				} else {
					if ($this->ref_id->Exportable) $Doc->ExportField($this->ref_id);
					if ($this->emp_id->Exportable) $Doc->ExportField($this->emp_id);
					if ($this->emp_datelog->Exportable) $Doc->ExportField($this->emp_datelog);
					if ($this->emp_timein->Exportable) $Doc->ExportField($this->emp_timein);
					if ($this->emp_timeout->Exportable) $Doc->ExportField($this->emp_timeout);
					if ($this->emp_totalhours->Exportable) $Doc->ExportField($this->emp_totalhours);
					if ($this->emp_late->Exportable) $Doc->ExportField($this->emp_late);
					if ($this->emp_excesstime->Exportable) $Doc->ExportField($this->emp_excesstime);
					if ($this->emp_undertime->Exportable) $Doc->ExportField($this->emp_undertime);
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
