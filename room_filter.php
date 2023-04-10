<form action="" method="post">
            <select name="city">
                <option value="city">Select City</option>
                <?php 
                    $query ="SELECT DISTINCT city FROM hotel";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['city'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="'<?php echo $option; ?>'" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>
            <select name="peopleCapacity">
                <option value="peopleCapacity">Select people capacity</option>
                <?php 
                    $query ="SELECT DISTINCT peopleCapacity FROM Room";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['peopleCapacity'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>
            <select name="chain_name">
                <option value="chain_name">Select hotel chain</option>
                <?php 
                    $query ="SELECT DISTINCT chain_name FROM HotelChain";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['chain_name'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="'<?php echo $option; ?>'" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>

            <select name="ratingStars">
                <option value="ratingStars">Select rating categorie</option>
                <?php 
                    $query ="SELECT DISTINCT ratingStars FROM Hotel";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['ratingStars'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>

            <select name="view">
                <option value="view">Select room view</option>
                <?php 
                    $query ="SELECT DISTINCT view FROM Room";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['view'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="'<?php echo $option; ?>'" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>
            
            <select name="lowprice">
                <option value="0">Select lowest price</option>
                <?php 
                    $query ="SELECT DISTINCT price FROM Room";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['price'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>

            <select name="highprice">
                <option value="1000000">Select highest price</option>
                <?php 
                    $query ="SELECT DISTINCT price FROM Room";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['price'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>

            <input type="submit" name="submit" value="submit"/>
        </form>