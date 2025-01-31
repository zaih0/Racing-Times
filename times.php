<?php

    session_start();
    


            $fetchStmt = $pdo->prepare("SELECT * FROM tb_racetimes");
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