$('#telefone').mask('(00) 00000-0000').on('keyup', function(event){
   event.preventDefault();
   var v = this.value;
   console.log(v.length);
   if (v.length == 3) this.value = v+') 9';
});

$('#cpf').mask('000.000.000-00').on('keyup', function(event){
   event.preventDefault();
   var v = this.value;
   console.log(v.length);
   if (v.length === 3) this.value = v+') 9';
});

$('#rm').mask('0000000000').on('keyup', function(event){
   event.preventDefault();
   var v = this.value;
   console.log(v.length);
   if (v.length === 3) this.value = v+') 9';
});
