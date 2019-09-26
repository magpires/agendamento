function validaDados() {
    if (document.cadSolicitante.nomeCompleto.value === "") {
        alert("Informe seu nome completo!");
        document.cadSolicitante.nomeCompleto.focus();
        return false;
    }

    if (document.cadSolicitante.nomeCompleto.value.length > 255) {
        alert("Parece que seu nome é muito grande. Por favor, informe um nome menor! \nMáximo de 255 caracteres");
        document.cadSolicitante.nomeCompleto.focus();
        return false;
    }

    if (document.cadSolicitante.cpf.value === "") {
        alert("Informe o seu CPF!");
        document.cadSolicitante.cpf.focus();
        return false;
    }

    if (document.cadSolicitante.tipoSolicitante.value === "0") {
        alert("Selecione o tipo solicitante!");
        document.cadSolicitante.tipoSolicitante.focus();
        return false;
    }

    if (document.cadSolicitante.tipoSolicitante.value === "1") {
        if (document.cadSolicitante.rm.value === "") {
            alert("Informe o seu Registro Acadêmigo! (RM)");
            document.cadSolicitante.rm.focus();
            return false;
        }
    }

    if (document.cadSolicitante.tipoSolicitante.value === "1") {
        if (document.cadSolicitante.tipoCurso.value === "0") {
            alert("Informe o seu curso!");
            document.cadSolicitante.tipoCurso.focus();
            return false;
        }
    }

    if (document.cadSolicitante.email.value === "") {
        alert("Informe o seu email!");
        document.cadSolicitante.email.focus();
        return false;
    }

    if (document.cadSolicitante.email.value.length > 255) {
        alert("Parece que seu email é muito grande. Por favor, informe um email menor! \nMáximo de 255 caracteres");
        document.cadSolicitante.email.focus();
        return false;
    }

    if (document.cadSolicitante.confirmEmail.value !== document.cadSolicitante.email.value) {
        alert("Os emails não correspondem!");
        document.cadSolicitante.confirmEmail.focus();
        return false;
    }

    if (document.cadSolicitante.password.value === "") {
        alert("Informe sua senha!");
        document.cadSolicitante.password.focus();
        return false;
    }

    if (document.cadSolicitante.password.value.length < 8) {
        alert("Senha muito curta! Informe uma senha com oito ou mais caracteres");
        document.cadSolicitante.password.focus();
        return false;
    }

    if (document.cadSolicitante.password.value.length > 255) {
        alert("Parece que sua senha é muito grande. Por favor, informe uma senha menor! \nMáximo de 255 caracteres");
        document.cadSolicitante.password.focus();
        return false;
    }

    if (document.cadSolicitante.confirmPassword.value !== document.cadSolicitante.password.value) {
        alert("As senhas não correspndem!");
        document.cadSolicitante.confirmPassword.focus();
        return false;
    }

    if (document.cadSolicitante.telefone.value === "") {
        alert("Informe o seu telefone!");
        document.cadSolicitante.telefone.focus();
        return false;
    }

    alert("Cadastro realizado com sucesso!\nFaça login para enviar e acompanhar seus tickets");
    //A próxima linha de código habilita o campo RM antes de enviar o formulário para o
    //banco, para evitar que um erro Undefined index apareça.
    document.getElementById("rm").disabled = false;
    return true;
}


