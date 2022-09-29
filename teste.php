<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, #105ac9, #0e3879);
        }
        .box{
            position: absolute; /*para ocupar apenas o espaço necessário*/
            top: 50%; /*para centralizar, da tag "top" até a tag "transform"*/
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 15px;
            width: 20%;
            color: white;
        }
        @media (max-width: 450px){
            .box{
                width: 80%;
            }
        }
    </style>
</head>
<body>
    <?php
        //dados que viriam através de um formulário
        $nome = $_POST["f_nome"];
        $salario = $_POST["f_salario"];
        $n_dependentes = $_POST["f_nDependentes"];
        $pensao_alimenticia = $_POST["f_pensao"];
        $outras_deduções = $_POST["f_outrasDeducoes"];

        $faixas = array(); //vetor com as faixas e suas respectivas faixas
        $faixas[1] = array(1903.98, 0);
        $faixas[2] = array(2826.65, 0.075);
        $faixas[3] = array(3751.05, 0.15);
        $faixas[4] = array(4664.68, 0.225);
        $faixas[5] = array(4664.68, 0.275);

        $base_do_calculo = $salario - ((189.59 * $n_dependentes) + $pensao_alimenticia + $outras_deduções);

        for($i = 5; $i > 0; $i--){ //percorrerá todas os índices do array $faixas de forma decrescente
            if($base_do_calculo > $faixas[$i][0]){
                if($base_do_calculo < 4664.68){
                    $faixa_do_usuario = $i+1;
                    $imposto = ($base_do_calculo - $faixas[$i][0]) * $faixas[$i+1][1];
                }
                else{
                    $faixa_do_usuario = $i;
                    $imposto = ($base_do_calculo - $faixas[$i][0]) * $faixas[$i][1];
                }
                for($j = $i; $j > 0; $j--){ //irá calcular a quantidade adicional do imposto
                    if($j == 1){
                        break 2;
                    }
                    $adicional = ($faixas[$j][0] - $faixas[$j-1][0]) * $faixas[$j][1];
                    $imposto = $imposto + $adicional;
                }
            }
        }
        
        $aliquota_efetiva = ($imposto / $base_do_calculo) * 100;
    ?>
    <div class="box">
        <?php
            printf("Estes são os seus dados %s: ", $nome);
            echo "<br>";
            echo "<br>";
            printf("- Seu salário: %.2f reais", $salario);
            echo "<br>";
            printf("- Seu imposto: %.2f reais", $imposto);
            echo "<br>";
            echo("- Sua faixa: " .$faixa_do_usuario);
            echo "<br>";
            printf("- Sua taxa efetiva: %.2f%%", $aliquota_efetiva);
        ?>
    </div>
</body>
        <!--
            ganha X de salário:
            base_do_cálculo = X - [(189,59 * nDependentes) + pensaoAlimentícia + outras]
            calcular imposto = ((base_do_calculo - faixa_anterior) * taxa_faixa_atual)
            imposto = imposto + adicional

            "adicional" refere-se a todos os impostos das faixas anteriores:
                ex para alguém com salário = 2.000,00 reais sem dependentes (faixa 3):
                    base_do_cálculo = 3.000,00
                    imposto = ((3.000,00 - 2.826,65) * 15%) = R$26,00
                    adicional = ((2.826,65 - 1.903,98) * 7,5%) = R$69,20
                    imposto = 26,00 + 69,20
                    imposto = 95,20

            ALGORITMO
            1- realizar a base do calculo
            2- identificar a faixa que o usuário se encontra
            3- calcular o imposto para a faixa
            4- adicionar ao imposto calculado os impostos das faixas anteriores
            5- calcular a aliquota efetiva
        -->
</html>
