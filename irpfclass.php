<?php
    class IRPF {
        private $income; /*Salário*/
        private $nDep; /*Número de dependentes*/
        private $otherDeductions; /* (array) Deduções */
        private $alimony = 0; /* Pensão alimentícia (inicialmente R$ 0,00) */
        private $discByDep = 189.59; /* Valor do desconto por dependente (incialmente R$ 189,59) */
        private $tax; /* Taxa de imposto da faixa que se enquadra */
        private $realtax; /* Taxa efetiva de imposto */
        private $valueTax; /* Valor do imposto a ser pago */

        public function __construct($income, $nDep, $otherDeductions, $alimony, $discByDep)
        {
            $this->income = $income;
            $this->nDep = $nDep;
            $this->otherDeductions = $otherDeductions;
            $this->alimony = $alimony;
            $this->discByDep = $discByDep;

        }
 
        public function setAlimony($alimony){
            $this->alimony = $alimony;
        }

        public function addDeductions($otherDeductions){
            $this->otherDeductions = $otherDeductions;
        }

        public function setDiscByDep ($nDep){
            $this->nDep = $nDep;
        }

        public function getIRPF ($valueTax){
            $this->valueTax = $valueTax;
        }

        public function getTax ($tax){
            /* deve retornar a taxa de imposto da faixa enquadrada */
            $base_do_calculo = $salario - ((189.59 * $n_dependentes) + $pensao_alimenticia + $outras_deduções);
            $faixas = array(); //vetor com as faixas e suas respectivas faixas
            $faixas[1] = array(1903.98, 0);
            $faixas[2] = array(2826.65, 0.075);
            $faixas[3] = array(3751.05, 0.15);
            $faixas[4] = array(4664.68, 0.225);
            $faixas[5] = array(4664.68, 0.275);

            for($i = 5; $i > 0; $i--){ //percorrerá todas os índices do array $faixas de forma decrescente
                if($base_do_calculo <= $faixas[$i][0]){
                    $this->$tax = $faixas[$i][0];
                    break;
                } else {
                    continue;
                }
            }
        }

        public function realTax (){
            /* deve retornar a taxa efetiva */
        }

        private calcTaxValue () {
            /* deve calcular o imposto e retornar o seu valor */
        }

        private calcRealTax () {
            /* deve calcular a taxa efetiva */
        }

        /* Obs.1: as faixas de valores devem estar em um vetor associativo (por nome de faixa) bidimensional, sendo que a primeira dimensão será a faixa, e a segunda um vetor com os valores de porcentagem e limite da faixa.
        - Obs.2: a classe deve estar em arquivo próprio separado, e ser importada pela interface inicial */
    }
?>
