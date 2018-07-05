<?php
template('admin/header');
if (isset($_POST['search'])) {
    core_header('!admin/searchUser/' . $_POST['email'], 0);
}
?>
<script>
function showResult(str) {
	if (str.length==0) { 
		document.getElementById("livesearch").innerHTML = "";
		document.getElementById("livesearch").style.border = "0px";
		return;
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
            if(this.responseText != '') {
				var myArr = JSON.parse(this.responseText);
				myFunction(myArr);
			}
		}
	};
	xmlhttp.open("GET", "<?php echo url; ?>get.php?type=users&num=1&email=" + str, true);
	xmlhttp.send();
	function myFunction(arr) {
		var out = "";
		var i;
		for(i = 0; i < arr.length; i++) {
			out += '<a href="'+ arr[i].email + '">' + 
			arr[i].email + '</a><br>';
		}
		document.getElementById("livesearch").innerHTML = out;
		document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
	}
}
</script>

<div class="col-md-4 col-md-offset-3 content">
    <form action="" method="POST">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo language('titles', 'SEARCH_USER'); ?>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="text" class="form-control" name="email" onkeyup="showResult(this.value)" placeholder="<?php echo language('others', 'EMAIL'); ?>" aria-describedby="basic-addon1">
					<div id="livesearch"></div>
				</div>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="submit" class="btn btn-primary" name="search" value="<?php echo language('buttons', 'SEARCH'); ?>" />
                </div>
            </div>
        </div>
    </form>
</div>
<?php template('admin/footer'); ?>