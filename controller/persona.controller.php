<?php

class Persona_Controller {

    function nuevaPersona() {
        
            $name = strip_tags($_REQUEST["namePersona"]);
            $adress = strip_tags($_REQUEST["dirPersona"]);
            $mail = strip_tags($_REQUEST["mailPersona"]);
            $phone = strip_tags($_REQUEST["telPersona"]);
            $rol = strip_tags($_REQUEST["rol"]);
            
            if (filter_var($name, FILTER_VALIDATE_FLOAT) || filter_var($mail, FILTER_VALIDATE_EMAIL) || !filter_var($phone, FILTER_VALIDATE_INT) || !filter_var($rol, FILTER_VALIDATE_INT)) {
                if($rol!=0){
                    die("Error al cargar");
                } else {
                    $var_persona = new Persona_Model;
                    $respuesta = $var_persona->nuevaPersona($name, $adress, $mail, $phone, $rol);
                }
            } else {
                $var_persona = new Persona_Model;
                $respuesta = $var_persona->nuevaPersona($name, $adress, $mail, $phone, $rol);
            }
            $cadena = "";
            if ($rol == cliente) {
                $cadena = "Location: index.php?action=Persona::verPersonas&type=cliente";
            } else {
                $cadena = "Location: index.php?action=Persona::verPersonas&type=proveedor";
            }
            return header($cadena);
    }

    function modificarPersona() {
        if ($_SESSION["conect"] == TRUE) {
            $id_persona = strip_tags($_REQUEST["id"]);
            $date = strip_tags($_REQUEST["fecha"]);
            $name = strip_tags($_REQUEST["nombre"]);
            $adress = strip_tags($_REQUEST["direccion"]);
            $mail = strip_tags($_REQUEST["mail"]);
            $phone = strip_tags($_REQUEST["phone"]);
            $rol = strip_tags($_REQUEST["rol"]);
            if (filter_var($name, FILTER_VALIDATE_FLOAT) || filter_var($mail, FILTER_VALIDATE_EMAIL) || !filter_var($phone, FILTER_VALIDATE_INT) || !filter_var($rol, FILTER_VALIDATE_INT)) {
                echo "<script>
                alert('Ocurrio un error, no se pudieron cargar los datos deseados\nVuelva a intentarlo por favor');
                  </script>";
            } else {
                $var_persona = new Persona_Model();
                $respuesta = $var_persona->modificarPersona($id_persona, $date, $name, $adress, $mail, $phone, $rol);
            }

            return $this->verPersonas();
        } else {
            return header("Location: index.php");
        }
    }

    function eliminarPersona() {
        if ($_SESSION["conect"] == TRUE) {
            $id_persona = strip_tags($_REQUEST["id"]);
            $var_persona = new Persona_Model();
            $roles = $var_persona->verPersona($id_persona);
            $rol = -1;
            foreach ($roles as $r) {
                $rol = $r["rol"];
            }
            if ($rol == 1) {
                $cadena = "Location: index.php?action=Persona::verPersonas&type=cliente";
            } else {
                $cadena = "Location: index.php?action=Persona::verPersonas&type=proveedor";
            }
            $respuesta = $var_persona->eliminarPersona($id_persona);
            if ($respuesta == FALSE) {
                echo "<script>
                alert('La persona deseada no puede eliminarse, posee documentos relacionados');
                </script>";
                exit();
            }
            return header($cadena);
        } else {
            return header("Location: index.php");
        }
    }

    function verPersona() {
        if ($_SESSION["conect"] == TRUE) {
            $id_Persona = strip_tags($_REQUEST["id"]);
            $var_persona = new Persona_Model;
            $respuesta = $var_persona->verPersona($id_Persona);
            $tpl = new TemplatePower("templates/verPersona.html");
            $tpl->prepare();

            foreach ($respuesta as $respuest) {

                $tpl->assign("var_lis_cod", $respuest["id_persona"]);
                $tpl->assign("apellidoNombre", $respuest["name"]);
                $tpl->assign("direccion", $respuest["address"]);
                $tpl->assign("phone", $respuest["phone"]);
                $tpl->assign("mail", $respuest["mail"]);
                $type;
                if ($respuest["rol"] == cliente) {
                    $tpl->assign("rol", "Cliente");
                    $type = "cliente";
                } else {
                    $tpl->assign("rol", "Proveedor");
                    $type = "proveedor";
                }
            }
            $tpl->assign("var_type", $type);
            return $tpl->getOutputContent();
        } else {
            return header("Location: index.php");
        }
    }

    function verPersonasRol($rol) {
        $var_persona = new Persona_Model();
        $respuesta = $var_persona->verPersonasRol($rol);
        return $respuesta;
    }

    function verPersonas() {
        if ($_SESSION["conect"] == TRUE) {
            $type = $_REQUEST["type"];
            $tpl = new TemplatePower("templates/listadoPersonas.html");
            $tpl->prepare();
            $tpl->gotoBlock("_ROOT");
            $var_persona = new Persona_Model();
            $respuesta = $var_persona->listarSaldos();

            if ($type == "cliente") {
                $tpl->assign("var_list_rol", "Clientes");
                foreach ($respuesta as $r) {
                    if ($r["rol"] == cliente) {
                        $tpl->newBlock("block_listado_personas");
                        $tpl->assign("var_list_nam", $r["name"]);
                        $tpl->assign("var_lis_cod", $r["id_persona"]);

                        $debeSQL = $var_persona->totalFactura($r["id_persona"]);
                        $debe = 0;
                        foreach ($debeSQL as $d) {
                            $debe = $d["suma_factura"];
                        }

                        $haberSQL = $var_persona->totalCobro($r["id_persona"]);
                        $haber = 0;
                        foreach ($haberSQL as $h) {
                            $haber = $h["suma_cobro"];
                        }
                        //if($haber==NULL)$haber=0;

                        $dif = $debe - $haber;
                        if ($dif <= 0) {
                            $tpl->assign("var_list_cuenta", "$ " . abs($dif));
                            $tpl->assign("color_cuenta", "btn btn-success");
                        } elseif ($dif > 0) {
                            $tpl->assign("var_list_cuenta", "-$ " . $dif);
                            $tpl->assign("color_cuenta", "btn btn-danger");
                        } else {
                            $tpl->assign("var_list_cuenta", "");
                            $tpl->assign("color_cuenta", "");
                        }
                        $cadena = "personaExport" . $r["id_persona"];
                        $tpl->assign("nameCheckBox", $cadena);
                        $tpl->assign("idPersona", $r["id_persona"]);
                    }
                }
                $personaNocliente = $var_persona->listarPersonas(1);
                foreach ($personaNocliente as $p) {
                    $tpl->newBlock("block_listado_personas");
                    $tpl->assign("var_list_nam", $p["name"]);
                    $tpl->assign("var_lis_cod", $p["id_persona"]);
                    $cadena = "personaExport" . $p["id_persona"];
                    $tpl->assign("nameCheckBox", $cadena);
                    $tpl->assign("idPersona", $p["id_persona"]);
                }
            } else {
                $tpl->assign("var_list_rol", "Proveedores");
                $tpl->gotoBlock("_ROOT");
                foreach ($respuesta as $r) {
                    if ($r["rol"] == proveedor) {
                        $tpl->newBlock("block_listado_personas");
                        $tpl->assign("var_list_nam", $r["name"]);
                        $tpl->assign("var_lis_cod", $r["id_persona"]);

                        $debeSQL = $var_persona->totalFactura($r["id_persona"]);
                        $debe = 0;
                        foreach ($debeSQL as $d) {
                            $debe = $d["suma_factura"];
                        }



                        $haberSQL = $var_persona->totalCobro($r["id_persona"]);
                        $haber = 0;
                        foreach ($haberSQL as $h) {
                            $haber = $h["suma_cobro"];
                        }
                        //if($haber==NULL)$haber=0;

                        $dif = $debe - $haber;
                        if ($dif <= 0) {
                            $tpl->assign("var_list_cuenta", "$ " . abs($dif));
                            $tpl->assign("color_cuenta", "btn btn-success");
                        } else {
                            $tpl->assign("var_list_cuenta", "-$ " . $dif);
                            $tpl->assign("color_cuenta", "btn btn-danger");
                        }
                        $cadena = "personaExport" . $r["id_persona"];
                        $tpl->assign("nameCheckBox", $cadena);
                        $tpl->assign("idPersona", $r["id_persona"]);
                    }
                }
                $personaNocliente = $var_persona->listarPersonas(0);
                foreach ($personaNocliente as $p) {
                    $tpl->newBlock("block_listado_personas");
                    $tpl->assign("var_list_nam", $p["name"]);
                    $tpl->assign("var_lis_cod", $p["id_persona"]);
                    $cadena = "personaExport" . $p["id_persona"];
                    $tpl->assign("nameCheckBox", $cadena);
                    $tpl->assign("idPersona", $p["id_persona"]);
                }
            }
            return $tpl->getOutputContent();
        } else {
            return header("Location: index.php");
        }
    }

    function altaModificarPersona() {
        if ($_SESSION["conect"] == TRUE) {
            $idPersona = strip_tags($_REQUEST["id"]);
            $persona = new Persona_model();
            $respuesta = $persona->verPersona($idPersona);

            $tpl = new TemplatePower("templates/modificarPersona.html");
            $tpl->prepare();
            $tpl->gotoBlock("_ROOT");
            foreach ($respuesta as $res) {
                $tpl->assign("var_lis_cod", $res["id_persona"]);
                $tpl->assign("var_lis_fech", $res["createDate"]);
                $tpl->assign("apellidoNombre", $res["name"]);
                $tpl->assign("direccion", $res["address"]);
                $tpl->assign("phone", $res["phone"]);
                $tpl->assign("mail", $res["mail"]);
                $type = "";
                if ($res["rol"] == cliente) {
                    $type = "cliente";
                    $tpl->assign("defecto0", "");
                    $tpl->assign("defecto1", "selected");
                } else {
                    $type = "proveedor";
                    $tpl->assign("defecto0", "selected");
                    $tpl->assign("defecto1", "");
                }
            }
            $tpl->assign("var_type", $type);
            return $tpl->getOutputContent();
        } else {
            return header("Location: index.php");
        }
    }

    function altaPersona() {
        if ($_SESSION["conect"] == TRUE) {
            $tpl = new TemplatePower("templates/nuevaPersona.html");
            $tpl->prepare();
            $tpl->gotoBlock("_ROOT");
            return $tpl->getOutputContent();
        } else {
            return header("Location: index.php");
        }
    }

    function verPersonaCuenta() {
        if ($_SESSION["conect"] == TRUE) {
            $id_persona = $_REQUEST["id"];
            $tpl = new TemplatePower("templates/detallesCompraVenta.html");
            $tpl->prepare();
            $tpl->gotoBlock("_ROOT");

            $fecha = getdate();
            $d = $fecha["mday"];
            $m = $fecha["mon"];
            $a = $fecha["year"];
            $conFecha = $d . "-" . $m . "-" . $a;

            $cadena = "";
            $rolPersona = -1;
            $var_persona = new Persona_Model();
            $fact = new Factura_Model();
            $persona = $var_persona->verPersona($id_persona);
            foreach ($persona as $person) {
                $rolPersona = $person["rol"];
                if ($person["rol"] == cliente) {
                    $cadena = "Cliente: " . $person["name"];
                } else {
                    $cadena = "Proveedor: " . $person["name"];
                    $tpl->assign("Codigo_compra", "Codigo Compra");
                }
            }
            $row = $var_persona->verCuentaFactura($id_persona);
            $tpl->assign("var_list_titulo", $cadena);

            $debe = 0;
            $haber = 0;

            foreach ($row as $r) {
                $tpl->newBlock("block_listado_cuenta");
                $tpl->assign("var_list_fecha", $r["fecha"]);
                $tpl->assign("var_list_nro_pedido", $r["codigo"]);

                if ($r["tipo"] == 'factura') {
                    $tpl->assign("var_cuenta", $r["precio"]);
                    $tpl->assign("var_abonado", "");
                    $tpl->assign("link", "index.php?action=Factura::verFactura&id=" . $r["codigo"]);
                    $debe += $r["precio"];
                    if ($rolPersona == proveedor) {
                        $result = $fact->verFactura($r["codigo"]);
                        foreach ($result as $res) {
                            $tpl->assign("codigo_compra_detalle", $res["codiogoCompra"]);
                        }
                    }
                } else {
                    $tpl->assign("var_cuenta", "");
                    $tpl->assign("var_abonado", $r["precio"]);
                    $tpl->assign("link", "index.php?action=Cobros::verCobro&id=" . $r["codigo"]);
                    $haber += $r["precio"];
                }


                $tpl->assign("var_id_persona", $id_persona);
                //$tpl->assign("var_list_fecha",$r["fecha_cobro"]);
            }

            $tpl->gotoBlock("_ROOT");
            $actual = $debe - $haber;
            $tpl->assign("var_debe", $debe);
            $tpl->assign("var_haber", $haber);
            $tpl->assign("var_fecha", $conFecha);
            $tpl->assign("var_id_persona", $id_persona);
            if ($actual > 0) {
                $tpl->assign("clase_estilo", "text-danger");
                $tpl->assign("var_estado_cuenta", $actual);
            } else {
                $tpl->assign("clase_estilo", "text-success");
                $tpl->assign("var_estado_cuenta", abs($actual));
            }


            return $tpl->getOutputContent();
        } else {
            return header("Location: index.php");
        }
    }

    function exportarDatos() {
        if ($_SESSION["conect"] == TRUE) {
            $stringFechas = strip_tags($_REQUEST['tabla']);
            $fechas = json_decode($stringFechas, TRUE);
            $mesDesde = $fechas[0];
            $mesHasta = $fechas[1];
            $añoDesde = $fechas[2];
            $añoHasta = $fechas[3];

            $personaSelected = [];
            $personas = new Persona_Model;
            $listado = $personas->verPersonas();
            $rol;
            foreach ($listado as $l) {
                $cadena = "personaExport" . $l["id_persona"];
                if (!empty($_REQUEST[$cadena])) {
                    array_push($personaSelected, $l["id_persona"]);
                    $rol = $l["rol"];
                }
            }

            $totalSeleccionadas = count($personaSelected);
            $todos = [];

            for ($i = 0; $i < $totalSeleccionadas; $i++) {
//            echo 'PERSONA'.$i.'---ID----------->'.$personaSelected[$i];
//            echo '<br>';
                $respu = $personas->exportarDatos($personaSelected[$i], $mesDesde, $mesHasta, $añoDesde, $añoHasta);
                $debe = 0;
                $haber = 0;
                $monto = 0;
                $tabla = [];

                $nro_filas = $respu->num_rows;
                $h = 1;
                foreach ($respu as $r) {
                    $fila = [];
                    $fila["fecha"] = $r["fecha"];
                    $fila["persona"] = $r["persona"];
                    $fila["codigo"] = $r["codigo"];
                    $fila["codigoCompra"] = $r["codigoCompra"];
                    $fila["detalle"] = $r["detalle"];

                    if ($r["tipo"] == "factura") {
                        $fila["debe"] = $r["precio"];
                        $fila["haber"] = "";
                        $debe += $r["precio"];
                    } else {
                        $fila["haber"] = $r["precio"];
                        $fila["debe"] = "";
                        $haber += $r["precio"];
                    }
                    $fila["saldo"] = "";
                    array_push($tabla, $fila);


                    if ($h == $nro_filas) {
                        $monto = $haber - $debe;
                        $fila["fecha"] = "";
                        $fila["persona"] = "";
                        $fila["codigo"] = "";
                        $fila["codigoCompra"] = "";
                        $fila["detalle"] = "";
                        $fila["debe"] = "";
                        $fila["haber"] = "";
                        $fila["saldo"] = $monto;
                        array_push($tabla, $fila);
                    }
                    $h++;
                }

                $personas->eliminarTemporales();
                array_push($todos, $tabla);
            }

//        var_dump($todos);
//        die;
            $this->enviarExcel($todos);
        } else {
            return header("Location: index.php");
        }
    }

    function enviarExcel($tam) {
        $totalDePersonas = count($tam);
        // Crea un nuevo objeto PHPExcel        
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()
                ->setCreator("Códigos de Programación")
                ->setLastModifiedBy("Códigos de Programación")
                ->setTitle("Excel en PHP")
                ->setSubject("Documento de prueba")
                ->setDescription("Documento generado con PHPExcel")
                ->setKeywords("excel phpexcel php")
                ->setCategory("Ejemplos");


        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Hoja 1');



        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Fecha')
                ->setCellValue('B1', 'Proveedor/Cliente')
                ->setCellValue('C1', 'Codigo Compra/Venta')
                ->setCellValue('D1', 'Codigo Compra')
                ->setCellValue('E1', 'Gastos')
                ->setCellValue('F1', 'Abonado')
                ->setCellValue('G1', 'Detalle-Abonado')
                ->setCellValue('H1', 'Saldo');
        $count = '2';
        for ($i = 0; $i < $totalDePersonas; $i++) {
            $tabla = $tam[$i];
            foreach ($tabla as $key => $value) {
                $A = 'A' . $count;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($A, $value['fecha']);
                $B = 'B' . $count;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($B, $value['persona']);
                $C = 'C' . $count;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($C, $value['codigo']);
                $D = 'D' . $count;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($D, $value['codigoCompra']);
                $E = 'E' . $count;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($E, $value['debe']);
                $F = 'F' . $count;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($F, $value['haber']);
                $G = 'G' . $count;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($G, $value['detalle']);
                $H = 'H' . $count;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($H, $value['saldo']);
                $count++;
            }
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Excel.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');


        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit();
        return 0;
    }

}
