<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script>
    function toggleCardBody(item, e) {

        console.log("Toggle card body", item, e);
        console.log(e.textContent);
    }
    </script>

</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <form>
                    <div class="form-row  align-items-center">
                        <div class="form-group mx-3 mb-2">
                            <label for="inputPassword2">Shipper</label>
                            <input type="password" class="form-control" id="inputPassword2" placeholder="Shipper #">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="inputPassword2">Destination</label>
                            <input type="password" class="form-control" id="inputPassword2" placeholder="Destination">
                        </div>

                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Shipped</label>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="card-container  col-6">
                <div class="card">
                    <div class="card-header" onclick="toggleCardBody('item1', this)">
                        Item 1
                    </div>
                    <div class="card-body open">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cb1" value="option1">
                            <label class="form-check-label" for="cb1">Item 1</label>
                        </div>
                    </div>
                    <div>
                        <div class="card-header" onclick="toggleCardBody('item2', this)">
                            Item 2
                        </div>
                        <div class="card-body" style="display: none;">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">
                                With supporting text below as a natural lead-in to additional
                                content.
                            </p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                    <div class="card-header" onclick="toggleCardBody('item3', this)">
                        Item 3
                    </div>
                </div>
            </div>

            <div class="card-container  col-6">
                <div class="card">
                    <div class="card-header">
                        On Shipment
                    </div>
                    <div class="card-body">
                        List of items
                    </div>

                </div>
            </div>
        </div>
</body>

</html>