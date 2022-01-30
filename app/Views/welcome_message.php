<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="http://rankanswer.com:8000/css/tms.css">
<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/tms.css'); ?>"> -->
<title>개인정보</title>
<script language="javascript">
	var objForm;
	
	function init(){ 
/*	
<%
	if (cUpdateSucc.equals("1")) {
%>
		alert('성공적으로 수정되었습니다.');
		parent.frames['tms_header'].window.location.reload();
		parent.frames['tms_left'].window.location.reload();
<%
	}
%>
		objForm = document.frmBody; 
	}
	*/
	function update() {
		
		/*if (objForm.pwd.value == "") {
			alert("패스워드를 입력 하세요.");
			objForm.pwd.focus();
			return;
		}*/
		
		if (objForm.pwd.value != objForm.pwd_confirm.value) {
			alert("패스워드가 일치 하지 않습니다.");
			objForm.pwd.focus();
			return;
		}
	
		objForm.submit();
	}

	function addSearch() {
		 popupCenter('/Common.tms?method=getAddrList','addrSearch',"702","470");
	}
</script>
</head>
<body leftmargin="0" topmargin="0" onLoad="init();"> 
<html:form  action="UserMg.tms" method="post">
<input type="hidden" name="method" value="updateUserInfo">
<input type="hidden" name="zip_code" value="">
<input type="hidden" name="user_id" value="">
<table border="0" width="705" cellpadding="0" cellspacing="0">
    <tr>
		<td width="705"  align="center" valign="top">
			<table width="705" height="">
				<tr>
					<td width="705" height="42" valign="top">
						<table border="0" width="100%" id="table1" cellspacing="1">
							<tr>
								<td align="left">사용자관리 > 사용자관리 > <b>개인정보</b></td>
							</tr>
						</table>
						<br style="line-height:30px">
						<table border="0" width="100%" id="table1" cellspacing="1">
							<tr>
								<td align="left">
									<img src="/common/img/icon/icon_cir_orange.gif" align="absmiddle">
									<font size="2"><b>개인정보</b></font>
								</td>
							</tr>
						</table>
						<br style="line-height:10px">
						<table class="recordTable" width="710">
							<tr>
								<td colspan="4" class="line_bu3"></td>
							</tr>
							<tr>
								<td width="150" align="right" bgColor="#f2f8fb">아이디&nbsp;&nbsp;</td>
								<td width="200"></td>
								<td width="150" align="right" bgColor="#f2f8fb">소속사&nbsp;&nbsp;</td>
								<td width="200"></td>
							</tr>
   							<tr>
								<td width="150" align="right" bgColor="#f2f8fb">담당자명&nbsp;&nbsp;</td>
								<td width="200">
									<input type="text" name="user_nm" size="15" maxlength="50" value="">
								</td>
								<td width="150" align="right" bgColor="#f2f8fb">전화번호&nbsp;&nbsp;</td>
								<td width="200">
									<input type="text" name="phone" size="15" maxlength="13" value="">
								</td>
							</tr>
							<tr>
								<td width="150" align="right" bgColor="#f2f8fb">등록일 &nbsp;&nbsp;</td>
								<td width="200"></td>
								<td width="150" align="right" bgColor="#f2f8fb">팩스번호&nbsp;&nbsp;</td>
								<td width="200">
									<input type="text" name="fax" size="15" maxlength="13" value="">
								</td>
							</tr>
							<tr>
								<td width="150" align="right" bgColor="#f2f8fb">주 소&nbsp;&nbsp;</td>
								<td width="200" colspan="3">
								<input type="text" name="zip_code1" size="3" readonly value=""> - 
								<input type="text" name="zip_code2" size="3" readonly value="">
								<a href="javascript:addSearch()"><img src="/common/img/button/but_search_zip.gif" ></a>
								<br>
									<input type="text" name="addr1" size=87 maxlength="100" readonly value="">&nbsp; 
									<input type="text" name="addr2" size=87 maxlength="100" value=">">
								</td>
							</tr>
							<tr>
								<td width="150" align="right" bgColor="#f2f8fb">패스워드 &nbsp;&nbsp;</td>
								<td width="200">
										<input type="password" name="pwd"  size="17" maxlength="25"> 
								</td>
								<td width="150" align="right" bgColor="#f2f8fb">패스워드 확인&nbsp;&nbsp;</td>
								<td width="200">
										<input type="password" name="pwd_confirm" size="17" maxlength="25">
								</td>
							</tr>
   						</table>
   						<br style="line-height:35px">
   						 <table  width="705">
							   <tr>
							  		<td align="right">
							  			<a href="javascript:update()"><img src="/common/img/button/but_menu_modify.gif"></a>
							  		</td>
							   </tr>
						  </table>	
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>	
</html:form>
</body>
</html>