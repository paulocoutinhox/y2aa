<?php

return [
    'Model.Id' => 'Id',
    'Model.CreatedAt' => 'Criado em',
    'Model.UpdatedAt' => 'Alterado em',

    'Model.Username' => 'Usuário',
    'Model.AuthKey' => 'Chave de autorização',
    'Model.PasswordHash' => 'Hash da senha',
    'Model.PasswordResetToken' => 'Token de recuperação da senha',
    'Model.Email' => 'Email',
    'Model.Gender' => 'Sexo',
    'Model.Status' => 'Status',
    'Model.Root' => 'Root',
    'Model.LoggedAt' => 'Último login',
    'Model.LanguageId' => 'Idioma',
    'Model.Avatar' => 'Avatar',
    'Model.Title' => 'Título',
    'Model.Content' => 'Conteúdo',
    'Model.Name' => 'Nome',
    'Model.NativeName' => 'Nome nativo',
    'Model.Code-ISO-639-1' => 'Código ISO-639-1',
    'Model.Code-ISO-Language' => 'Código ISO-Language',
    'Model.Description' => 'Descrição',
    'Model.Action' => 'Ação',
    'Model.ActionGroup' => 'Grupo da ação',
    'Model.UserId' => 'Usuário',
    'Model.GroupId' => 'Grupo',
    'Model.PermissionId' => 'Permissão',
    'Model.Tag' => 'Tag',
    'Model.Items' => 'Itens',
    'Model.TimeZone' => 'Fuso-horário',
    'Model.FirstName' => 'Nome',
    'Model.LastName' => 'Sobrenome',
    'Model.Password' => 'Senha',
    'Model.RepeatPassword' => 'Repetir senha',
    'Model.AvailableAt' => 'Disponível em',
    'Model.Type' => 'Tipo',
    'Model.Image' => 'Imagem',
    'Model.Video' => 'Video',
    'Model.ShortContent' => 'Resumo',
    'Model.CustomerId' => 'Cliente',
    'Model.Gallery.Items' => 'Imagens',
    'Model.Message' => 'Mensagem',
    'Model.VerifyCode' => 'Código de verificação',
    'Model.Token' => 'Token',
    'Model.ExternalId' => 'Código externo',
    'Model.Price' => 'Preço',
    'Model.Address1' => 'Logradouro',
    'Model.Address2' => 'Bairro',
    'Model.State' => 'Estado',
    'Model.City' => 'Cidade',
    'Model.Latitude' => 'Latitude',
    'Model.Longitude' => 'Longitude',
    'Model.MobilePhone' => 'Celular',
    'Model.HomePhone' => 'Convencional',
    'Model.ProductId' => 'Produto',
    'Model.ZipCode' => 'CEP',
    'Model.Obs' => 'Observação',
    'Model.Amount' => 'Quantidade',
    'Model.Total' => 'Total',
    'Model.ItemsAmount' => 'Qtd. de itens',
    'Model.ItemsTotal' => 'Total',
    'Model.SyncStatus' => 'Status da sincronização',
    'Model.ErrorAt' => 'Erro em',
    'Model.ErrorMessage' => 'Mensagem de erro',
    'Model.StartAt' => 'Inicia em',
    'Model.EndAt' => 'Finaliza em',
    'Model.ActionType' => 'Tipo de ação',
    'Model.ActionValue' => 'Valor da ação',
    'Model.Place' => 'Local',
    'Model.Reason' => 'Motivo',
    'Model.AddressType' => 'Tipo',
    'Model.AddressNumber' => 'Número',
    'Model.AddressComplement' => 'Complemento',
    'Model.Subtitle' => 'Subtítulo',
    'Model.Key' => 'Chave',
    'Model.Value' => 'Valor',
    'Model.Contact' => 'Contato',
    'Model.Level' => 'Nível',
    'Model.Source' => 'Origem',
    'Model.Footer' => 'Rodapé',
    'Model.Query' => 'Query',
    'Model.RememberMe' => 'Lembrar-me',
    'Model.CPF' => 'CPF',

    'Gender.Male' => 'Masculino',
    'Gender.Female' => 'Feminino',

    'Status.Active' => 'Ativo',
    'Status.Inactive' => 'Inativo',
    'Status.Created' => 'Criado',
    'Status.Used' => 'Usado',
    'Status.Pending' => 'Pendente',
    'Status.Canceled' => 'Cancelado',
    'Status.Error' => 'Erro',
    'Status.Success' => 'Sucesso',
    'Status.None' => 'Nenhum',
    'Status.Shipping' => 'Enviando',
    'Status.NotApproved' => 'Não aprovado',
    'Status.NotFound' => 'Não encontrado',
    'Status.Deleted' => 'Removido',

    'Root.Yes' => 'Sim',
    'Root.No' => 'Não',

    'Gallery.Tag.Frontend' => 'Frontend',

    'Content.Tag.AboutUs' => 'Quem somos',
    'Content.Tag.PrivacyPolicy' => 'Política de privacidade',
    'Content.Tag.TermsOfUse' => 'Termos de uso',

    'Mail.CustomerRequestPasswordReset.Subject' => 'Troca de senha para: {name}',
    'Mail.CustomerRequestPasswordReset.Body.Html' => '
        <p>Olá {name},</p>
        <p>Acesse o link abaixo para redefinir sua senha:</p>
        <p>{link}</p>
    ',
    'Mail.CustomerRequestPasswordReset.Body.Text' => "
        Olá {name},\n\n
        Acesse o link abaixo para redefinir sua senha:\n\n
        {link}
    ",

    'Mail.Contact.Subject' => 'Email de contato do site',
    'Mail.Contact.Body.Html' => '
        <p>Olá, chegou uma nova mensagem de contato do site.</p>
        <br>
        <strong>Usuário logado:</strong>
        <p>ID: {customer.id}</p>
        <p>Nome: {customer.name}</p>
        <p>Email: {customer.email}</p>
        <br>
        <strong>Dados do formulário:</strong>
        <p>Nome: {form.name}</p>
        <p>Email: {form.email}</p>
        <br>
        <strong>Mensagem:</strong>
        <p>{form.message}</p>
    ',
    'Mail.Contact.Body.Text' => "
        Olá, chegou uma nova mensagem de contato do site.\n\n
        \n\n
        Usuário logado:\n\n
        ID: {customer.id}\n\n
        Nome: {customer.name}\n\n
        Email: {customer.email}\n\n
        \n\n
        Dados do formulário:\n\n
        Nome: {form.name}\n\n
        Email: {form.email}\n\n
        \n\n
        Mensagem:\n\n
        {form.message}     
    ",

    'Mail.SignUpVerification.Subject' => 'Validação de cadastro em {name}',
    'Mail.SignUpVerification.Body.Html' => '
        <p>Olá {name},</p>
        <p>Acesse o link abaixo para validar seu email de cadastro:</p>
        <p>{link}</p>
    ',
    'Mail.SignUpVerification.Body.Text' => "
        Olá {name},\n\n
        Acesse o link abaixo para validar seu email de cadastro:\n\n
        {link}      
    ",

    'Mail.Welcome.Subject' => 'Bem-vindo à {name}',
    'Mail.Welcome.Body.Html' => '
        <p>Olá {customer.name},</p>
        <p>Seja bem-vindo!</p>
        <p>Ficamos felizes ter você conosco.</p>
    ',
    'Mail.Welcome.Body.Text' => "
        Olá {customer.name},\n\n
        \n\n
        Seja bem-vindo!\n\n
        \n\n
        Ficamos felizes ter você conosco.\n\n
        \n\n
        \n\n
        Equipe Y2AA   
    ",

    'TimeZone.Validator.Invalid' => 'O fuso horário é inválido',

    'Item.WithoutImage' => 'Sem imagem',

    'Level.Verbose' => 'verbose',
    'Level.Debug' => 'debug',
    'Level.Info' => 'info',
    'Level.Warning' => 'warning',
    'Level.Error' => 'error',

    'Log.Source.Api' => 'api',
    'Log.Source.ExternalService' => 'serviço externo',
    'Log.Source.System' => 'sistema',

    'Error.Customer.ResendVerificationEmail.EmailNotFound' => 'Desculpe, o email informado não é válido. Verifique se você digitou o email de cadastro corretamente.',
    'Error.Customer.ResendVerificationEmail' => 'Desculpe, não conseguimos reenviar o email de verificação para o endereço informado.',
    'Error.Customer.ResendVerificationEmail.EmptyToken' => 'O token para validar o cadastro não pode ser vazio.',
    'Error.Customer.ResendVerificationEmail.InvalidToken' => 'O token para validar o cadastro é inválido.',
    'Error.Customer.RequestPasswordReset.EmailNotFound' => 'Desculpe, o email informado não é válido. Verifique se você digitou o email de cadastro corretamente.',
    'Error.Customer.RequestPasswordReset.EmptyToken' => 'O token para definir uma nova senha não pode ser vazio.',
    'Error.Customer.RequestPasswordReset.InvalidToken' => 'O token para definir uma nova senha é inválido.',
    'Error.Login.IncorrectEmailPassword' => 'Email ou senha inválido.',
    'Error.Login.CustomerNotActive' => 'Não é permitido o login com estes dados.',

    'Error.User.UsernameTaken' => 'Este usuário já está sendo utilizado.',
    'Error.User.EmailTaken' => 'Este email já está sendo utilizado.',
    'Error.Customer.EmailTaken' => 'Este email já está sendo utilizado.',
    'Error.General.TokenTaken' => 'Este token já está sendo utilizado.',

    'Message.Customer.ResendVerificationEmail.Success' => 'Verifique seu email para as demais instruções.',
];