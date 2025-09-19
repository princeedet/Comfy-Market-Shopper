<?php
include 'config.php';
header('Content-Type: application/json');

$data = $_POST;

// Convert checkbox arrays/log formats to string
$data['allow_signup'] = isset($data['allow_signup']) ? 1 : 0;
$data['notifications'] = isset($data['notifications']) ? 1 : 0;
$data['log_format'] = isset($data['log_format']) ? implode(',', $data['log_format']) : '';

try {
  $check = $conn->query("SELECT id FROM system_settings LIMIT 1")->fetch_assoc();
  if($check){
    $stmt = $conn->prepare("UPDATE system_settings SET system_language=?, admin_theme=?, timezone=?, currency=?, system_font=?, allow_signup=?, user_theme=?, datetime_format=?, notifications=?, dashboard_layout=?, update_frequency=?, security_frequency=?, log_format=? WHERE id=?");
    $stmt->bind_param(
      "sssssiisssssi",
      $data['system_language'], $data['admin_theme'], $data['timezone'], $data['currency'], $data['system_font'], $data['allow_signup'], $data['user_theme'], $data['datetime_format'], $data['notifications'], $data['dashboard_layout'], $data['update_frequency'], $data['security_frequency'], $data['log_format'], $check['id']
    );
    $stmt->execute();
  } else {
    $stmt = $conn->prepare("INSERT INTO system_settings (system_language, admin_theme, timezone, currency, system_font, allow_signup, user_theme, datetime_format, notifications, dashboard_layout, update_frequency, security_frequency, log_format) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param(
      "sssssiissssss",
      $data['system_language'], $data['admin_theme'], $data['timezone'], $data['currency'], $data['system_font'], $data['allow_signup'], $data['user_theme'], $data['datetime_format'], $data['notifications'], $data['dashboard_layout'], $data['update_frequency'], $data['security_frequency'], $data['log_format']
    );
    $stmt->execute();
  }
  echo json_encode(['success'=>true]);
} catch(Exception $e){
  echo json_encode(['success'=>false,'msg'=>$e->getMessage()]);
}
