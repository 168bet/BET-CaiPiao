<?php
//欧赔平均赔率

require_once 'global.func.php';
require_once 'conn.php';

$sql = "REPLACE INTO `bt_europeodds_total` SELECT
                                            `scheduleid`,
                                            AVG(`homewin_f`),
                                            AVG(`guestwin_f`),
                                            AVG(`homewin`),
                                            AVG(`guestwin`),
                                            AVG(`probability_h0`),
                                            AVG(`probability_g0`),
                                            AVG(`probability_t0`),
                                            AVG(`probability_h1`),
                                            AVG(`probability_g1`),
                                            AVG(`probability_t1`)
                                        FROM  `bt_europeodds`
                                        GROUP BY  `scheduleid`";

$mysqli->query($sql);
$mysqli->close();