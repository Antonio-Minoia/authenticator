<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/logo.png">
    <title>Accedi a MBK</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body style="background-color:#F2F2F2">
    <div class="container wrapper">
        <div>
        <img class="m-5" src="../assets/images/logo.png" style="width: 200px" class="bg-grey"></img>
        </div>
        <form>
            <!-- Username -->
            <div class="field">
                <label class="label has-text-grey">Username</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" placeholder="Username" id="username" name="username">
                    <span class=" icon is-small is-left has-text-grey-darker">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
            </div>
            <!-- Password -->
            <div class="field">
                <label class="label has-text-grey">Password</label>
                    <div class="control has-icons-left">
                        <input id="password" name="password" class="input" type="password" placeholder="Password">
                        <span class="icon is-small is-left has-text-grey-darker">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                    <div>
                        <button class="button mt-2" style="background-color: #F2F2F2; width: 25px; height: 25px" onclick="togglePassword()"><i id="eye" class="fas fa-eye-slash"></i></button>
                    </div>
                <p class="help is-danger" id="error"></p>
            </div>

            <div class="control">
                <button class="button mt-3" style="background-color: #EA7322;" id="#accedi">Accedi</button>
            </div>
        </form>
    </div>
    

    <script src="./app.js"></script>
</body>

</html>