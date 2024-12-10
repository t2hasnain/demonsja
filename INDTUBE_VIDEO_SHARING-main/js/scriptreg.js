function togglePassword(inputId) 
{
    var passwordInput = document.getElementById(inputId);

    if (passwordInput.type === "password") 
    {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}

function adjustRegisterPosition() 
{
    var registerDiv = document.querySelector('.login__register');
    var alertDiv = document.querySelector('.login__Form .alert');

    if (alertDiv && registerDiv) 
    {
        var alertHeight = alertDiv.offsetHeight;
        registerDiv.style.marginTop = '-43px';

        if (alertHeight>0) 
        {
            registerDiv.classList.add('not-registered-glow');
        } else {
            registerDiv.classList.remove('not-registered-glow');
        }
    }
}

window.addEventListener('load', adjustRegisterPosition);
window.addEventListener('resize', adjustRegisterPosition);
