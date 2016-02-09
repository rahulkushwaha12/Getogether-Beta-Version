
<?php
include("./inc/header.inc.php");
error_reporting(0);
echo '<div style="height:40px; width:100%; background-color:0ff;"></div>';
if(!isset($_SESSION["user_login"])){
	echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
}
else{
	

?>
<div class="homeTitleBar" style="background-color:0ff;">
<div class="homeTopics">
<h2>Topics</h2>
</div>

<div class="newsFeed">
<h2>Question and Answers Forum</h2>

</div>
</div>

<div class="homeContent" style="background-color:0ff;">

<div class="homeLeftSide" style="background-color:0ff;">
  <ul class="navigation">
<li><a href="topics.php?topic=science-technology"><img src="images/sciandtech.jpg" height="50" width="50"><div class="txt">Science and Technology</div></a></li>
<li><a href="topics.php?topic=books-studies"><img src="images/bookandstu.jpg" height="50" width="50"><div class="txt">Books <br> and Studies</div></a></li>
<li><a href="topics.php?topic=music-movies"><img src="images/musicandmov.jpg" height="50" width="50"><div class="txt">Music<br> and Movies</div></a></li>
<li><a href="topics.php?topic=fashion-style"><img src="images/fashionandsty.jpg" height="50" width="50"><div class="txt">Fashion<br> and Style</div></a></li>
<li><a href="topics.php?topic=friendship-relationships"><img src="images/frndandrelation.jpg" height="50" width="50"><div class="txt">Friendship Vs Relationships</div></a></li>
<li><a href="topics.php?topic=writing-literature"><img src="images/writingandlite.jpg" height="50" width="50"><div class="txt">Writing<br> and Literature</div></a></li>
<li><a href="topics.php?topic=travel-photography"><img src="images/travelandphoto.jpg" height="50" width="50"><div class="txt">Travel<br> and Photography</div></a></li>
<li><a href="topics.php?topic=health-wealth"><img src="images/healandwealth.jpg" height="50" width="50"><div class="txt">Health<br> and Wealth</div></a></li>
<li><a href="topics.php?topic=graduation-colleges"><img src="images/graduandclg.jpg" height="50" width="50"><div class="txt">Graduation<br>and Colleges</div></a></li>
<li><a href="topics.php?topic=miscellaneous-talks"><img src="images/misctalks.jpg" height="50" width="50"><div class="txt">Miscellaneous <br>Talks</div></a></li>  
  Copyright © 2014 | GeTogether   
                
        </ul>
       
</div>

<div class="homeRightSide" style=" background-color:0ff;">
<!-- slider ##################################################################################-->
 <div id="sliderFrame" style="background-color:0ff; margin-top:50px;">
        <div id="slider" style="background-color:0ff;">
         <img src="images/image-slider-1.jpg" alt="#cap0" height="400"/>
         <img src="images/sciandtech.jpg" alt="#cap1" height="400" />
         <img src="images/bookandstu.jpg" alt="#cap2" height="400" />
         <img src="images/musicandmov.jpg" alt="#cap3" height="400" />
         <img src="images/fashionandsty.jpg" alt="#cap4"  height="400"/>
         <img src="images/frndandrelation.jpg" alt="#cap5" height="400" />
         <img src="images/writingandlite.jpg" alt="#cap6" height="400" />
         <img src="images/travelandphoto.jpg" alt="#cap7" height="400" />
         <img src="images/healandwealth.jpg" alt="#cap8" height="400"/>
         <img src="images/graduandclg.jpg" alt="#cap9" height="400"/>
         <img src="images/misctalks.jpg" alt="#cap10" height="400"/>
        </div>
      
<div id="cap0" style="display:none;"><a href="#">welcome to GeTogether</a></div>
<div id="cap1" style="display:none;"><a href="topics.php?topic=science-technology">Science and Technology</a></div>
<div id="cap2" style="display:none;"><a href="topics.php?topic=books-studies">Books and Studies</a></div>
<div id="cap3" style="display:none;"><a href="topics.php?topic=music-movies">Music and Movies</a></div>
<div id="cap4" style="display:none;"><a href="topics.php?topic=fashion-style">Fashion and Style</a></div>
<div id="cap5" style="display:none;"><a href="topics.php?topic=friendship-relationships">Friendship Vs Relationships</a></div>
<div id="cap6" style="display:none;"><a href="topics.php?topic=writing-literature">Writing and Literature</a></div>
<div id="cap7" style="display:none;"><a href="topics.php?topic=travel-photography">Travel and Photography</a></div>
<div id="cap8" style="display:none;"><a href="topics.php?topic=health-wealth">Health and Wealth</a></div>
<div id="cap9" style="display:none;"><a href="topics.php?topic=mnnit-feavour">Graduation and Colleges</a></div>
<div id="cap10" style="display:none;"><a href="topics.php?topic=miscellaneous-talks">Miscellaneous Talks</a></div>

    </div>
<!-- end of slider #######################################################################################-->

</div>


</div>
<?php
}
?>