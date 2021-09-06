
<?php class venda extends Generic
{
    public function export () {
        $filename = 'cuistomer_order_' . date('Y-m-d_His') . '.csv';
 
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="' . $filename . '";');
   
  $f = fopen('php://output', 'w');
 
  fputcsv($f,[1,2,3], ';');
 
        fputcsv($f, [1,2,4], ';');
 
  exit;
    }
}
?>
