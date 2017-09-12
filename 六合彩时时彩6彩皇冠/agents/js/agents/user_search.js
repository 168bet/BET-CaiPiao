//admin/user_mang/user_browse.php 快速搜尋功能 

function showSearchDlg() {
	var obj_win = document.getElementById('searchDlg');
	obj_win.style.top = document.body.scrollTop+event.clientY+15;
	obj_win.style.left = document.body.scrollLeft+event.clientX-100;
	obj_win.style.display = "block";

	var dlg_option = document.getElementById('dlg_option');
	var dlg_text = document.getElementById('dlg_text');
	dlg_text.value = document.myFORM.search.value;
	dlg_text.focus();
	dlg_text.select();
}
function closeSearchDlg() {
	var obj_win = document.getElementById('searchDlg');
	obj_win.style.top = document.body.scrollTop+event.clientY+15;
	obj_win.style.left = document.body.scrollLeft+event.clientX-20;
	obj_win.style.display = "none";
}
function submitSearchDlg() {
	var dlg_option = document.getElementById('dlg_option');
	var dlg_text = document.getElementById('dlg_text');

	document.myFORM.search.value = dlg_text.value;
	document.myFORM.submit();
}