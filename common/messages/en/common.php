<?php

return [
    'Model.Id' => 'Id',
    'Model.CreatedAt' => 'Created at',
    'Model.UpdatedAt' => 'Updated at',

    'Model.Username' => 'Username',
    'Model.AuthKey' => 'Authorization key',
    'Model.PasswordHash' => 'Password hash',
    'Model.PasswordResetToken' => 'Password reset token',
    'Model.Email' => 'Email',
    'Model.Gender' => 'Gender',
    'Model.Status' => 'Status',
    'Model.Root' => 'Root',
    'Model.LoggedAt' => 'Last login',
    'Model.LanguageId' => 'Language',
    'Model.Avatar' => 'Avatar',
    'Model.Title' => 'Title',
    'Model.Content' => 'Content',
    'Model.Name' => 'Name',
    'Model.NativeName' => 'Native name',
    'Model.Code-ISO-639-1' => 'Code ISO-639-1',
    'Model.Code-ISO-Language' => 'Code ISO-Language',
    'Model.Description' => 'Description',
    'Model.Action' => 'Action',
    'Model.ActionGroup' => 'Action group',
    'Model.UserId' => 'User',
    'Model.GroupId' => 'Group',
    'Model.PermissionId' => 'Permission',
    'Model.Tag' => 'Tag',
    'Model.Items' => 'Items',
    'Model.TimeZone' => 'TimeZone',
    'Model.FirstName' => 'First name',
    'Model.LastName' => 'Last name',
    'Model.Password' => 'Password',
    'Model.RepeatPassword' => 'Repeat password',
    'Model.AvailableAt' => 'Available at',
    'Model.Type' => 'Type',
    'Model.Image' => 'Image',
    'Model.Video' => 'Video',
    'Model.ShortContent' => 'Short content',
    'Model.CustomerId' => 'Customer',
    'Model.Gallery.Items' => 'Images',
    'Model.Message' => 'Message',
    'Model.VerifyCode' => 'Verification code',
    'Model.Token' => 'Token',
    'Model.ExternalId' => 'External ID',
    'Model.Price' => 'Price',
    'Model.Address1' => 'Address 1',
    'Model.Address2' => 'Address 2',
    'Model.State' => 'State',
    'Model.City' => 'City',
    'Model.Latitude' => 'Latitude',
    'Model.Longitude' => 'Longitude',
    'Model.MobilePhone' => 'Mobile phone',
    'Model.HomePhone' => 'Home phone',
    'Model.ProductId' => 'Product',
    'Model.ZipCode' => 'ZipCode',
    'Model.Obs' => 'Note',
    'Model.Amount' => 'Amount',
    'Model.Total' => 'Total',
    'Model.ItemsAmount' => 'Items amount',
    'Model.ItemsTotal' => 'Total',
    'Model.SyncStatus' => 'Sync status',
    'Model.ErrorAt' => 'Error at',
    'Model.ErrorMessage' => 'Error message',
    'Model.StartAt' => 'Start at',
    'Model.EndAt' => 'End at',
    'Model.ActionType' => 'Action type',
    'Model.ActionValue' => 'Action value',
    'Model.Place' => 'Place',
    'Model.Reason' => 'Reason',
    'Model.AddressType' => 'Address type',
    'Model.AddressNumber' => 'Address number',
    'Model.AddressComplement' => 'Address complement',
    'Model.Subtitle' => 'Subtitle',
    'Model.Key' => 'Key',
    'Model.Value' => 'Value',
    'Model.Contact' => 'Contact',
    'Model.Level' => 'Level',
    'Model.Source' => 'Source',
    'Model.Footer' => 'Footer',
    'Model.Query' => 'Query',
    'Model.RememberMe' => 'Remember me',
    'Model.CPF' => 'CPF',

    'Gender.Male' => 'Male',
    'Gender.Female' => 'Female',

    'Status.Active' => 'Active',
    'Status.Inactive' => 'Inactive',
    'Status.Created' => 'Created',
    'Status.Used' => 'Used',
    'Status.Pending' => 'Pending',
    'Status.Canceled' => 'Canceled',
    'Status.Error' => 'Error',
    'Status.Success' => 'Success',
    'Status.None' => 'None',
    'Status.Shipping' => 'Shipping',
    'Status.NotApproved' => 'Not approved',
    'Status.NotFound' => 'Not found',
    'Status.Deleted' => 'Deleted',

    'Root.Yes' => 'Yes',
    'Root.No' => 'No',

    'Gallery.Tag.Frontend' => 'Frontend',

    'Content.Tag.AboutUs' => 'About us',
    'Content.Tag.PrivacyPolicy' => 'Privacy policy',
    'Content.Tag.TermsOfUse' => 'Terms of use',

    'Mail.CustomerRequestPasswordReset.Subject' => 'Password change for: {name}',
    'Mail.CustomerRequestPasswordReset.Body.Html' => '
        <p>Hi {name},</p>
        <p>Access the link below to reset your password:</p>
        <p>{link}</p>
    ',
    'Mail.CustomerRequestPasswordReset.Body.Text' => "
        Hi {name},\n\n
        Access the link below to reset your password:\n\n
        {link}
    ",

    'Mail.Contact.Subject' => 'Site contact email',
    'Mail.Contact.Body.Html' => '
        <p>Hello, a new contact message has arrived from the site.</p>
        <br>
        <strong>User logged in:</strong>
        <p>ID: {customer.id}</p>
        <p>Name: {customer.name}</p>
        <p>Email: {customer.email}</p>
        <br>
        <strong>Form data:</strong>
        <p>Name: {form.name}</p>
        <p>Email: {form.email}</p>
        <br>
        <strong>Message:</strong>
        <p>{form.message}</p>
    ',
    'Mail.Contact.Body.Text' => "
        Hello, a new contact message has arrived from the site.\n\n
        \n\n
        User logged in:\n\n
        ID: {customer.id}\n\n
        Name: {customer.name}\n\n
        Email: {customer.email}\n\n
        \n\n
        Form data:\n\n
        Name: {form.name}\n\n
        Email: {form.email}\n\n
        \n\n
        Message:\n\n
        {form.message}     
    ",

    'Mail.SignUpVerification.Subject' => 'Validation of registration in {name}',
    'Mail.SignUpVerification.Body.Html' => '
        <p>Hi {name},</p>
        <p>Access the link below to validate your registration email:</p>
        <p>{link}</p>
    ',
    'Mail.SignUpVerification.Body.Text' => "
        Hi {name},\n\n
        Access the link below to validate your registration email:\n\n
        {link}      
    ",

    'Mail.Welcome.Subject' => 'Welcome to {name}',
    'Mail.Welcome.Body.Html' => '
        <p>Hi {customer.name},</p>
        <p>Be welcome!</p>
        <p>We are happy to have you with us.</p>
    ',
    'Mail.Welcome.Body.Text' => "
        Hi {customer.name},\n\n
        \n\n
        Be welcome!\n\n
        \n\n
        We are happy to have you with us.\n\n
        \n\n
        \n\n
        Team Y2AA   
    ",

    'TimeZone.Validator.Invalid' => 'The time zone is invalid',

    'Item.WithoutImage' => 'No image',

    'Level.Verbose' => 'verbose',
    'Level.Debug' => 'debug',
    'Level.Info' => 'info',
    'Level.Warning' => 'warning',
    'Level.Error' => 'error',

    'Log.Source.Api' => 'api',
    'Log.Source.ExternalService' => 'external service',
    'Log.Source.System' => 'system',

    'Error.Customer.ResendVerificationEmail.EmailNotFound' => 'Sorry, the email provided is not valid. Check that you have entered the registration email correctly.',
    'Error.Customer.ResendVerificationEmail' => 'Sorry, we were unable to resend the verification email to the address provided.',
    'Error.Customer.ResendVerificationEmail.EmptyToken' => 'The token to validate the registration cannot be empty.',
    'Error.Customer.ResendVerificationEmail.InvalidToken' => 'The token to validate the registration is invalid.',
    'Error.Customer.RequestPasswordReset.EmailNotFound' => 'Sorry, the email provided is not valid. Check that you have entered the registration email correctly.',
    'Error.Customer.RequestPasswordReset.EmptyToken' => 'The token for setting a new password cannot be empty.',
    'Error.Customer.RequestPasswordReset.InvalidToken' => 'The token for setting a new password is invalid.',
    'Error.Login.IncorrectEmailPassword' => 'Invalid email or password.',
    'Error.Login.CustomerNotActive' => 'Login with this data is not allowed.',

    'Error.User.UsernameTaken' => 'This username is already in use.',
    'Error.User.EmailTaken' => 'This email is already being used.',
    'Error.Customer.EmailTaken' => 'This email is already being used.',
    'Error.General.TokenTaken' => 'This token is already in use.',

    'Message.Customer.ResendVerificationEmail.Success' => 'Check your email for other instructions.',
];