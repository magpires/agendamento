/*
 Função para quando a pessoa Selecionar o Aluno, mostrar todos os cursos
 disponiveis
 

*/

function changeSelect() {

    var select = document.getElementById('tipoSolicitante');
    var selectCurso = document.getElementById('tipoCurso');

    var value = select.options[select.selectedIndex].value;
    

    //remove itens
    var length = selectCurso.options.length;
    var i;
    for (i = selectCurso.options.length - 1; i >= 0; i--)
    {
        selectCurso.remove(i);
    }

    if (value === '0') {

        var option1 = document.createElement('option');
        option1.value = '0';
        option1.text = 'Selecione o Curso';


        selectCurso.add(option1);

    } else if (value === '1' ) {

        var option = document.createElement('option');
        option.value = '0';
        option.text = 'Selecione o Curso';
        
        var option2 = document.createElement('option');
        option2.value = '1';
        option2.text = 'Administração - Matutino';
        
        var option3 = document.createElement('option');
        option3.value = '2';
        option3.text = 'Administração - Noturno';
        
        var option4 = document.createElement('option');
        option4.value = '3';
        option4.text = 'Análise de Sistemas';
        
        var option5 = document.createElement('option');
        option5.value = '4';
        option5.text = 'Arquitetura e Urbanismo - Matutino';
        
        var option6 = document.createElement('option');
        option6.value = '5';
        option6.text = 'Arquitetura e Urbanismo - Noturno';
        
        var option7 = document.createElement('option');
        option7.value = '6';
        option7.text = 'Ciências Biológicas - Matutino';
        
        var option8 = document.createElement('option');
        option8.value = '7';
        option8.text = 'Ciências Biológicas - Noturno';
        
        var option9 = document.createElement('option');
        option9.value = '8';
        option9.text = 'Ciências Contábeis';
        
        var option10 = document.createElement('option');
        option10.value = '9';
        option10.text = 'Direito - Matutino';
        
        var option11 = document.createElement('option');
        option11.value = '10';
        option11.text = 'Direito - Noturno';
        
        var option12 = document.createElement('option');
        option12.value = '11';
        option12.text = 'Educação Física - Matutino';
        
        var option13 = document.createElement('option');
        option13.value = '12';
        option13.text = 'Educação Física - Noturno';
        
        var option14 = document.createElement('option');
        option14.value = '13';
        option14.text = 'Enfermagem - Matutino';
        
        var option15 = document.createElement('option');
        option15.value = '14';
        option15.text = 'Enfermagem - Noturno';
        
        var option16 = document.createElement('option');
        option16.value = '15';
        option16.text = 'Engenharia Civil - Matutino';
        
        var option17 = document.createElement('option');
        option17.value = '16';
        option17.text = 'Engenharia Civil - Noturno';
        
        var option18 = document.createElement('option');
        option18.value = '17';
        option18.text = 'Engenharia de Computação';
        
        var option19 = document.createElement('option');
        option19.value = '18';
        option19.text = 'Engenharia de Produção - Matutino';
        
        var option20 = document.createElement('option');
        option20.value = '19';
        option20.text = 'Engenharia de Produção - Noturno';
        
        var option21 = document.createElement('option');
        option21.value = '20';
        option21.text = 'Engenharia de Software';
        
        var option22 = document.createElement('option');
        option22.value = '21';
        option22.text = 'Engenharia';
        
        var option23 = document.createElement('option');
        option23.value = '22';
        option23.text = 'Engenharia Mecânica';
        
        var option24 = document.createElement('option');
        option24.value = '23';
        option24.text = 'Farmácia - Matutino';
        
        var option25 = document.createElement('option');
        option25.value = '24';
        option25.text = 'Farmácia - Noturno';
        
        var option26 = document.createElement('option');
        option26.value = '25';
        option26.text = 'Filosofia';
        
        var option27 = document.createElement('option');
        option27.value = '26';
        option27.text = 'Fisioterapia - Matutino';
        
        var option28 = document.createElement('option');
        option28.value = '27';
        option28.text = 'Fisioterapia - Noturno';
        
        var option29 = document.createElement('option');
        option29.value = '28';
        option29.text = 'Nutrição - Matutino';
        
        var option30 = document.createElement('option');
        option30.value = '29';
        option30.text = 'Nutrição - Noturno';
        
        var option31 = document.createElement('option');
        option31.value = '30';
        option31.text = 'Psicologia';
        
        var option32 = document.createElement('option');
        option32.value = '31';
        option32.text = 'Serviços Sociais - Matutino';
        
        var option33 = document.createElement('option');
        option33.value = '32';
        option33.text = 'Serviços Sociais - Noturno';

        var option34 = document.createElement('option');
        option34.value = '33';
        option34.text = 'Sistemas de Informação - Noturno';
        
        var option35 = document.createElement('option');
        option35.value = '34';
        option35.text = 'Tecnologia em Análise e Desenvolvimento de Sistemas - Noturno';
        
        var option36 = document.createElement('option');
        option36.value = '35';
        option36.text = 'Tecnologia em Design de Interiores';
        
        var option37 = document.createElement('option');
        option37.value = '36';
        option37.text = 'Tecnologia em Logística';
        
        var option38 = document.createElement('option');
        option38.value = '37';
        option38.text = 'Tecnologia em Redes de Computadores - Noturno';

        selectCurso.add(option);
        selectCurso.add(option2);
        selectCurso.add(option3);
        selectCurso.add(option4);
        selectCurso.add(option5);
        selectCurso.add(option6);
        selectCurso.add(option7);
        selectCurso.add(option8);
        selectCurso.add(option9);
        selectCurso.add(option10);
        selectCurso.add(option11);
        selectCurso.add(option12);
        selectCurso.add(option13);
        selectCurso.add(option14);
        selectCurso.add(option15);
        selectCurso.add(option16);
        selectCurso.add(option17);
        selectCurso.add(option18);
        selectCurso.add(option19);
        selectCurso.add(option20);
        selectCurso.add(option21);
        selectCurso.add(option22);
        selectCurso.add(option23);
        selectCurso.add(option24);
        selectCurso.add(option25);
        selectCurso.add(option26);
        selectCurso.add(option27);
        selectCurso.add(option28);
        selectCurso.add(option29);
        selectCurso.add(option30);
        selectCurso.add(option31);
        selectCurso.add(option32);
        selectCurso.add(option33);
        selectCurso.add(option34);
        selectCurso.add(option35);
        selectCurso.add(option36);
        selectCurso.add(option37);
        selectCurso.add(option38);
        
    } else {
        var option1 = document.createElement('option');
        option1.value = '0';
        option1.text = 'N/A';


        selectCurso.add(option1);
    }
}


