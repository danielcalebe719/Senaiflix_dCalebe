<?php
    function Status($n){
        switch ($n) {
            case 0: return "Inativo";
            case 1: return "Ativo";
        }
    }

    function FormatDate($date) {
        return date('d/m/Y', strtotime($date));
    }
?>