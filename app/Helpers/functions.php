<?php 
use Carbon\Carbon;
function converte_valor_monetario ($valor) {
    $valor = preg_replace('/[^0-9\,\.]/','', $valor);

    if($valor !== "") {
        $valor = str_replace(",",".",$valor);
        $valor = number_format($valor,2,".","");
        return $valor;
    } else {
        return null;
    }
}

function return_array_datas_parcelamento ($data_inicial, $numero_parcelas) {
    $data_carbon = Carbon::parse($data_inicial);
    $datas = array();
    for($i=0;$i<$numero_parcelas;$i++) {
        $datas[] = $data_carbon->format('Y-m-d');
        $data_carbon = $data_carbon->addMonth();
    }
    return $datas;
}

function imprime_valor_brl ($valor) {
    return 'R$' . number_format($valor, 2);
}