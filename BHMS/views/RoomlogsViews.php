<?php

require 'GeneralViews.php';
require '../controllers/RoomlogsController.php';

class RoomlogsViews extends GeneralViews{

    public static function room_logs_header() {
        echo <<<HTML
            <div class="header-container" >
                <span class="page-header">Room Logs</span><br>
            </div>
        HTML;
    }

    public static function room_info_cards() {

        $rooms = RoomlogsController::all_rooms();
    
        foreach ($rooms as $room) {
            
            $avail_color = '';
            $availability = '';
            $avail_info = '';
            
            if (intval($room['rentCount']) == intval($room['capacity'])) {
                $avail_color = '#ff0000';
                $availability = 'Not Available';
                $avail_info = 'FULLY OCCUPIED';
            } 
            else if (intval($room['rentCount']) < intval($room['capacity']) && intval($room['rentCount']) > 0) {
                $avail_color = '#ff8d23';
                $availability = 'Available (BS only)';
                $avail_info = htmlspecialchars($room['rentCount']) . '/' . htmlspecialchars($room['capacity']);
            } 
            else {
                $avail_color = '#00ba00';
                $availability = 'Available';
                $avail_info = 'NOT OCCUPIED';
            }
    
            $roomID = htmlspecialchars($room['roomID']);
    
            echo '
                <div class="col-auto">
                    <div class="rm-info-container">
                        <div class="rm-info-head">
                            <span class="rm-info-code">'.$roomID.'</span>
                            <i class="fa-solid fa-circle" style="color: '.$avail_color.';"></i>
                            <i type="button" class="fa-solid fa-ellipsis" style="color: #c7d5dd" data-bs-toggle="modal" 
                            data-bs-target="#rm-info-modal-'.$roomID.'"></i>
                        </div>
                        <div>
                            <span class="rm-info-avail">'.$availability.'</span><br>
                            <span class="rm-info-status" style="color: '.$avail_color.'">'.$avail_info.'</span> 
                        </div>
                    </div>
                </div>
            ';
        }
    }
    
    public static function room_info_modal() {
        $rooms = RoomlogsController::all_rooms();
    
        foreach ($rooms as $room) {
            $availability = '';
            $avail_info = '';
            
            if (intval($room['rentCount']) == intval($room['capacity'])) {
                $availability = 'Not Available';
                $avail_info = 'FULLY OCCUPIED';
            } 
            else if (intval($room['rentCount']) < intval($room['capacity']) && intval($room['rentCount']) > 0) {
                $availability = 'Available (BS only)';
                $avail_info = htmlspecialchars($room['rentCount']) . '/' . htmlspecialchars($room['capacity']);
            } 
            else {
                $availability = 'Available';
                $avail_info = 'NOT OCCUPIED';
            }
    
            $room_tenants = RoomlogsController::room_tenants($room['roomID']);
        
            $roomID = htmlspecialchars($room['roomID']);

            echo <<<HTML
                <script>console.log({json_encode($room_tenants)});</script>
            HTML;
    
            echo <<<HTML
                <div class="modal fade" id="rm-info-modal-{$roomID}" tabindex="-1" aria-labelledby="room-information" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="rm-modal-title" id="room-information">Room Information</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <p class="rm-modal-info">Room Code: <span>{$roomID}</span> </p>
                                    <p class="rm-modal-info">Availability: <span>{$availability}</span></p>
                                    <p class="rm-modal-info">Status: <span>{$avail_info}</span></p>
                                </div>
                                <div class="rm-occupants">
                                    <p class="rm-modal-info">Occupants: </p>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Tenant Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                HTML;
    
                        foreach ($room_tenants as $room_tenant) {
                            $rm_tenant_info = RoomlogsController::query_room_tenant($room_tenant['tenID']);
                
                            $rm_tenFname = htmlspecialchars($rm_tenant_info['tenFname']);
                            $rm_tenLname = htmlspecialchars($rm_tenant_info['tenLname']);
                            $rm_tenMI = htmlspecialchars($rm_tenant_info['tenMI']);
                
                            $name = $rm_tenFname . ' ' . $rm_tenMI . '. ' . $rm_tenLname;
                            $start_date = htmlspecialchars($room_tenant['occDateStart']);
                            $end_date = htmlspecialchars($room_tenant['occDateEnd']);
                
                            echo <<<HTML
                                <tr>
                                    <td>{$name}</td>
                                    <td>{$start_date}</td>
                                    <td>{$end_date}</td>
                                </tr>
                            HTML;
                        }
            echo <<<HTML
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            HTML;
        }
    }
    

}

?>