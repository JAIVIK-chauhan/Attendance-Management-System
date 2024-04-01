<head>
<link rel="stylesheet" href="mc.css"> 
<style>
     .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            border: none;
            transition: transform 0.3s ease; /* Only transform transition for the scaling effect */
            animation-name: color-change; /* Animation for background color change */
            animation-duration: 0.5s; /* Duration of the animation */
            animation-fill-mode: forwards; /* Retains the last keyframe state after the animation ends */
        }

        button:hover {
            transform: scale(1.05); /* Scaling effect on hover */
        }
        @keyframes color-change {
            0% {
                background-color:  #eb0a0a ; /* Initial color */
            }
            100% {
                background-color: #21a325; /* Final color on hover */
            }
        }
        #date {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border:  1px solid #d10d0d;
            border-radius: 4px;
            background-color: #f9f9f9;
            color: #333;
            box-sizing: border-box;
            cursor: not-allowed; /* To show cursor as 'not-allowed' */
        }
        checkbox-container {
            display: flex;
            flex-direction: column;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }
        .checkbox-label input[type="checkbox"] {
            margin-right: 8px;
        }
        .output-container {
  background-color: #f4f4f4;
  border: 5px solid #ccc;
  padding: 10px;
  margin-top: 20px;
  text-align: center;
}

.output-container p {
  margin: 5px 0;
}

.output-container span {
  font-weight: bold;
  color: #007bff; /* Change this to the desired color */
}

.output-container {
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
            text-align: center; /* Align text to center */
          }
          
          .output-container p {
            margin: 5px 0;
          }
          
          .output-container span {
            font-weight: bold;
            color: #007bff; /* Change this to the desired color */
          }
          


</style>
</head>
<body bgcolor="lightblue">
    <form action="mc.php" method="POST">
        <center>
            <div class="form-container">
                
                <label for="date">Date:</label>
                <input type="text" id="date" name="date" value="<?php echo date('d/m/Y'); ?>" readonly><br><br>
                <label for="enrollment">Enrollment Number:</label>
                <input type="number" id="enrollment" name="en"><br><br>
                <label for="subject">Subject:</label>
                <div class="checkbox-container">
    <label class="checkbox-label">
        <input type="radio" name="subject" value="JAVA"> JAVA
    </label>
    <label class="checkbox-label">
        <input type="radio" name="subject" value="PYTHON"> PYTHON
    </label>
    <label class="checkbox-label">
        <input type="radio" name="subject" value="Operating_System"> Operating System
    </label>
    <label class="checkbox-label">
        <input type="radio" name="subject" value="FLUTTER"> FLUTTER
    </label>
</div>

        </div>
        <br><br>
                <input type="submit" name="submit" value="Mark Present" class="submit-btn">
                <input type="submit" name="get" value="Get Data" class="submit-btn">
            </div>
        </center>
    </form>
</body>

<?php
require("connect.php");

if(isset($_POST['submit'])) 
{ // Check if form is submitted
    $date = $_POST['date'];
    $en = $_POST['en'];
    $subject = $_POST['subject'];
    $pre = $subject;
    $subject = 'P';

    echo '<div class="output-container">';
    echo '<p>Date: <span>' . $date . '</span></p>';
    echo '<p>Enrollment Number: <span>' . $en . '</span></p>';
    echo '<p>Subject: <span>' . $pre . '</span></p>';
    echo '</div>';

    $check_query = "SELECT * FROM subject WHERE enrollment_no = '$en' AND date = '$date'";
    $result = mysqli_query($connect, $check_query);

    if(mysqli_num_rows($result) > 0)
    {
        $update_query = "UPDATE subject SET $pre = '$subject' WHERE enrollment_no = '$en' AND date = '$date'";
        if(mysqli_query($connect, $update_query)) {
            echo "Record updated successfully";
    } 
    else {
             echo "Error updating record: " . mysqli_error($connect);
        }
    } 
    else 
    {
        $insert_query = "INSERT INTO subject (enrollment_no, date, $pre) VALUES ('$en', '$date', '$subject')";
        if(mysqli_query($connect, $insert_query)) 
        {
            echo "Record inserted successfully";
         } 
    else {
        echo "Error inserting record: " . mysqli_error($connect);
    }
}


}

if(isset($_POST["get"]))
{
    $date = $_POST['date'];
    $en = $_POST['en']; 
    

    $extract = mysqli_query($connect,"SELECT * 
    FROM subject s  
    JOIN student st ON s.Enrollment_No = st.Enrollment_No
    WHERE s.Enrollment_No = '$en'
    ");

    while($row = mysqli_fetch_assoc($extract)) 
    {
        $name = $row['Name'];
        $branch = $row['Branch'];
        $div = $row['Div'];
        $date = $row['Date'];
        $java = $row['JAVA'];
        $python = $row['PYTHON'];
        $os = $row['Operating_System'];
        $flutter = $row['FLUTTER'];

            echo "<style>
            .horizontal-table {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-between;
                border: 1px solid #000000;
                padding: 10px;
                margin: 20px auto;
                width: 80%;
                background-color: #f2f2f2;
            }
            .horizontal-table div {
                flex: 1 1 auto;
                padding: 5px;
            }
            .horizontal-table .label {
                font-weight: bold;
            }
            .line-break {
                width: 100%;
            }
        </style>";
        
        echo "<div class='horizontal-table'>";
        echo "<div><span class='label'>Enrollment No:</span> $en</div>";
        echo "<div><span class='label'>Name:</span> $name</div>";
        echo "<div><span class='label'>Branch:</span> $branch</div>";
        echo "<div><span class='label'>Division:</span> $div</div>";
        echo "<div class='line-break'><hr></div>";
        echo "<div><span class='label'>Date:</span> $date</div>"; // Adding a line break after the Date field
        echo "<div><span class='label'>Java:</span> $java</div>";
        echo "<div><span class='label'>Python:</span> $python</div>";
        echo "<div><span class='label'>OS:</span> $os</div>";
        echo "<div><span class='label'>Flutter:</span> $flutter</div>";
        echo "</div>";
            
    }
}
?>