<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Install Shopify App</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

  <!-- Main Container -->
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
<form action="/redirect_to_auth" method="POST">
    <!-- Title -->
    <h1 class="text-2xl font-bold mb-6 text-center">Install Shopify App</h1>
    <!-- Shopify Domain Input -->
    <div class="mb-6">
      <label for="shop-domain" class="block text-gray-700 font-medium mb-2">Enter your Shopify Domain</label>
      <div class="flex items-center">
        <span class="text-gray-500">https://</span>
        <input
          id="shop-domain"
          type="text" name="domain"
          class="flex-1 border border-gray-300 rounded-l-none rounded-r-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
          placeholder="your-store" required="required"
        />
        <span class="text-gray-500 ml-2">.myshopify.com</span>
      </div>
      <p class="text-gray-400 text-sm mt-2">Please enter your Shopify domain (e.g., https://your-store.myshopify.com).</p>
    </div>
   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <!-- App List Section -->
    <div class="mb-6">
      <p class="text-gray-700 font-medium mb-2">Choose an App to Install</p>

      <!-- App List -->
      <ul class="space-y-4">
@foreach($apps as $app)   
        <li class="flex items-center">
          <input
            type="radio"
            id="app{{$app->id}}"
            name="app"
            value="{{$app->id}}" required="required"
            class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
          />
          <label for="app{{$app->id}}" class="ml-3 text-gray-700">ID:{{$app->id}} - {{$app->description}}</label>
        </li>
@endforeach
      </ul>
    </div>

    <!-- Install Button -->
    <div class="text-center">
      <button
        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" onclick_test="installApp()">
        Install App
      </button>
    </div>
    </form>
  </div>
  <script>
    function installApp() {
      const shopDomain = document.getElementById('shop-domain').value;
      const selectedApp = document.querySelector('input[name="app"]:checked').value;
      const _token = document.querySelector('input[name="_token"]').value;
      if (!shopDomain) {
        alert("Please enter a valid Shopify domain.");
        return;
      }
      if (!selectedApp) {
        alert("Please select an app to install.");
        return;
      }
    //   console.log(`Installing ${selectedApp.nextElementSibling.textContent} for ${shopDomain}.myshopify.com`);
      $.ajax({
                    url: "/redirect_to_auth",
                    type: "POST",
                    dataType: "json",
                    data: {
                        domain: shopDomain,
                        app: selectedApp,
                        _token: _token
                    },
                    success: function(data) {
                        if (data.authUrl) {
                            // 如果返回的data中包含授权URL，重定向用户到授权页面
                            window.location.href = data.authUrl;
                        } else {
                            alert("Authorization URL not found");
                        }
                    },
                    error: function() {
                        alert("Error during authorization.");
                    }
                });
                
    //   $.ajax({
    //       url: "/redirect_to_auth",
    //       type: "POST",
    //       dataType: "JSON",
    //       data: {domain: shopDomain,app:selectedApp,_token:_token},
    //       success:function(data){
    //         console.log(data);
    //       },
    //       error:function(){
    //         alert("error");
    //       }
    //     })
    }
  </script>

</body>
</html>
