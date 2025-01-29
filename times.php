<?php

    session_start();


            // Execute the statement
                if ($stmt->execute()) {
                $_SESSION['record_saved'] = true;
                header("Location: index.php");
                } else {
                echo "Error saving record.";
                }
            }

            $fetchStmt = $pdo->prepare("SELECT * FROM tb_racingtimes");
            $fetchStmt->execute();
            $records = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result = $mysqli->query($query)) {

                /* fetch associative array */
                while ($row = $result->fetch_assoc()) {
                    $field1name = $row["col1"];
                    $field2name = $row["col2"];
                    $field3name = $row["col3"];
                    $field4name = $row["col4"];
                    $field5name = $row["col5"];
                }
            
                /* free result set */
                $result->free();
            }
?>