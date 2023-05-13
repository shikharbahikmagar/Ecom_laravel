<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
</head>
<body>
    <table>
        <tr>
            <td>Dear {{ $name }}!</td>
        </tr>
        <tr>
            <td>Welcome to E-commerce Website.Your account is activated and Your account details are as below :-</td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
        </tr>
        <tr>
            <td>
                Name: {{ $name }}
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
        </tr>
        <tr>
            <td>
                Mobile: {{ $mobile }}
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
        </tr>
        <tr>
            <td>
                Email: {{ $email }}
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
        </tr>
        <tr>
            <td>
               Password: ********(as chosen by you)
            </td>
        </tr>
        <tr>
            <td>Thanks & Regards,</td>
        </tr>
        <tr>
            <td>E-commerce Website</td>
        </tr>
    </table>
</body>
</html>