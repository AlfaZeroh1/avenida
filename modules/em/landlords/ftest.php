<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link type="text/css" media="all" href="error.css" />
<link type="text/css" media="all" href="/wisedigits/estate/fs-css/jquery.ui.all.css"/>
<script src="/wisedigits/estate/js/jquery-1.9.1.js"></script>
<script src="/wisedigits/estate/js/ui/jquery-ui.js"></script>
<script src="functions.js"></script>
</head>

<body>
<form id="newcarform" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
 <div id="form">
<table width="100%">
                           
                  <tr>
                  <td>
                                <div class="row">
                                    <div class="label">Make Name:</div>
                                    <div class="input" id="make">
                                    <select id="makename" class="detail" name="carid">
										<option selected value="0"> - Select make - </option>
										<?php
                                            while($each_make = mysql_fetch_assoc($make))
                                            {
                                        ?>
												<option value="<?php echo $each_make['make_id'] ?>"><?php echo $each_make['make_name'] ?></option>
                                        <?php
											}
                                        ?>
                                    </select>
                                    </div>
                                    <div class="cb"></div>
                                </div>
                 </td>
                     </tr>
                     <tr>
                     <td>
                                <div class="row">
                                    <div class="label">Model Name:</div>
                                    <div class="input" id="model">
                                    <select id="modelname" class="detail" name="carid">
										<option selected value="0"> - Select model - </option>
                                    </select>
                                    </div>
                                    <div class="cb"></div>
                                    <div class="context"><a href="#" id="newmodel">+ new model</a></div>
                                    <div class="cb"></div>
                                </div>
                      </td>
                      </tr>
                      
                      <tr>
                      <td>
                                <div class="row">
                                    <div class="label">Number of cars:</div>
                                    <div class="input" id="numcars">
                                    <input type="text" id="num_of_cars" class="detail" name="num_of_cars" value="" />
                                    </div>
                                    <div class="context">eg. 1, 2, 3</div>
                                </div>
                                </td>
                      </tr>
                      <tr>
                      <td>
                                <div class="submit">
                                    <input type="submit" name="submit" id="submit" value="Submit" />
                                    <div class="cb"></div>
                                </div>
                                </td>
                       </tr>
                            
</table>
                        </form>
                        
</div>
</body>


</html>
