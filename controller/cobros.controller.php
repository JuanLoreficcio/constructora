<?php

class Cobros_Controller {

    function nuevoCobro() {
        $stringCobro = strip_tags($_REQUEST['data']);
        $cobros = json_decode($stringCobro, TRUE);
        $cobro = new Cobros_Model();
        $persona = new Persona_Controller();
        if (filter_var($cobros[0], FILTER_VALIDATE_FLOAT) || !filter_var($cobros[1], FILTER_VALIDATE_FLOAT) || !filter_var($cobros[3], FILTER_VALIDATE_INT)) {
            echo "<script>
                alert('Ocurrio un error, no se pudieron cargar los datos deseados\nVuelva a intentarlo por favor');
                  </script>";
        } else {
            $result = $cobro->nuevoCobro($cobros[0], $cobros[1], $cobros[2], $cobros[3]); //fecha,monto,detalle,persona
        }
        return $persona->verPersonaCuenta();
    }

    function altaModificarCobro() {
        $id_cobro = strip_tags($_REQUEST["id"]);
        $cobro = new Cobros_Model();
        $result = $cobro->verCobro($id_cobro);
        $personas = new Persona_Model();
        $tpl = new TemplatePower("templates/modificarCobro.html");
        $tpl->prepare();

        foreach ($result as $r) {
            $tpl->assign("var_lis_cod", $r["id_cobro"]);
            $persona = $personas->verPersona($r["id_persona"]);
            foreach ($persona as $p) {
                $namePersona = $p["name"];
            }
            $tpl->assign("apellidoNombre", $namePersona);
            $tpl->assign("fecha", $r["fecha"]);
            $tpl->assign("monto", $r["monto"]);
            $tpl->assign("detalle", $r["detalle"]);
            $tpl->assign("idPersona", $r["id_persona"]);
        }
        return $tpl->getOutputContent();
    }

    function modificarCobro() {
        $id_cobro = strip_tags($_REQUEST["id"]);
        $fecha = strip_tags($_REQUEST["fecha"]);
        $monto = strip_tags($_REQUEST["monto"]);
        $detalle = strip_tags($_REQUEST["detalle"]);
        $id_persona = strip_tags($_REQUEST["idPersona"]);

        if (filter_var($fecha, FILTER_VALIDATE_FLOAT) || !filter_var($monto, FILTER_VALIDATE_FLOAT) || !filter_var($id_persona, FILTER_VALIDATE_INT)) {
            $dir = "index.php?action=Persona::verPersonaCuenta&id=" . $cobros[3];
            echo "<script>
                alert('Ocurrio un error, no se pudieron cargar los datos deseados\nVuelva a intentarlo por favor');
                  </script>";
        } else {
            $cobro = new Cobros_Model();
            $result = $cobro->modificarCobro($id_cobro, $fecha, $detalle, $monto, $id_persona);
        }

        $cadena = "Location: index.php?action=Cobros::verCobro&id=" . $id_cobro;
        return header($cadena);
    }

    function eliminarCobro() {
        $id_cobro = strip_tags($_REQUEST["id"]);
        $id_per = strip_tags($_REQUEST["per"]);
        $cobro = new Cobros_Model();
        $result = $cobro->eliminarCobro($id_cobro);
        $row = $cobro->verCobro($id_cobro);
        foreach ($row as $r) {
            $id_persona = $r["id_persona"];
        }

        $personas = new Persona_Controller();
        $cadena = "Location: index.php?action=Persona::verPersonaCuenta&id=" . $id_per;
        return header($cadena);
    }

    function verCobro() {
        $id_cobro = strip_tags($_REQUEST["id"]);
        $cobro = new Cobros_Model();
        $result = $cobro->verCobro($id_cobro);
        $personas = new Persona_Model();
        $tpl = new TemplatePower("templates/detallePagoCobro.html");
        $tpl->prepare();

        foreach ($result as $r) {
            $tpl->assign("var_lis_cod", $r["id_cobro"]);
            $persona = $personas->verPersona($r["id_persona"]);
            foreach ($persona as $p) {
                $namePersona = $p["name"];
            }
            $tpl->assign("apellidoNombre", $namePersona);
            $tpl->assign("fecha", $r["fecha"]);
            $tpl->assign("monto", $r["monto"]);
            $tpl->assign("detalle", $r["detalle"]);
            $tpl->assign("idPersona", $r["id_persona"]);
        }
        return $tpl->getOutputContent();
    }

    function verCobro_date($date) {
        $cobro = new Cobros_Model();
        $result = $cobro->verCobro_date($date);
        return $result;
    }

    function verCobro_id($id_persona) {
        $cobro = new Cobros_Model();
        $result = $cobro->verCobro_id($id_persona);
        return $result;
    }

}
