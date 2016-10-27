 <topbar> 
 	<ul>
 		<li class="dropdown" style="margin-left:200px">
 			<a href="#" class="dropbtn">Sales Leads</a>
    			    <div class="dropdown-content">
      				<a href="twoMonthsLeads.php?username=na&conversionStatus=close">Closed Sales Leads</a>
			        <a href="twoMonthsLeads.php?username=na&conversionStatus=open">Open Sales Leads</a>
			        <a href="twoMonthsLeads.php?username=na&conversionStatus=Interested">Converted Sales Leads</a>
			    </div>
		</li>
  		<li class="dropdown">
  			<a href="#task" class="dropbtn">Tasks</a>
    			    <div class="dropdown-content">
      				<a href="allTasks.php?state=all">Closed Tasks</a>
			        <a href="allTasks.php?state=INPROGRESS">Open Task</a>
			    </div> 
  		</li>
 		<li><a href="#contact">Properties</a></li>
 		<li class="dropdown" style="float:right">
 			<a class="active" ><?php echo strtoupper($user) ?></a>
    			    <div class="dropdown-content">
    			    	<a href="twoMonthsLeads.php?username=nona&conversionStatus=close">My Closed Sales Leads</a>
    			    	<a href="member.php">My Open Sales Leads</a>
    			    	<a href="myTasks.php?state=all">My All Tasks</a>
    			    	<a href="myTasks.php?state=INPROGRESS">My Open Tasks</a>
      				<a href="index.php">Logout</a>
			    </div> 			
 		</li>
 	</ul>
 </topbar>