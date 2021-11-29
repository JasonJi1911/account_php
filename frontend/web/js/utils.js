
function setupWebViewJavascriptBridge(callback) {
  if (window.WebViewJavascriptBridge) {
    return callback(WebViewJavascriptBridge);
  }
  if (window.WVJBCallbacks) {
    return window.WVJBCallbacks.push(callback);
  }
  window.WVJBCallbacks = [callback];
  var WVJBIframe = document.createElement('iframe');
  WVJBIframe.style.display = 'none';
  WVJBIframe.src = 'https://__bridge_loaded__';
  document.documentElement.appendChild(WVJBIframe);
  setTimeout(function () {
    document.documentElement.removeChild(WVJBIframe)
  }, 0)
}

// call ios native 
function iosBridgeCallHandler(name, data, callback) {
  setupWebViewJavascriptBridge(function(bridge) {
    bridge.callHandler(name, data, function responseCallback(responseData) {
      callback(responseData);
    })
  })
}

// register ios native
function iosBridgeRegisterHandler(name, callback) {
  setupWebViewJavascriptBridge(function(bridge) {
    bridge.registerHandler(name, function(data, responseCallback) {
      callback(data)
      responseCallback(data)
    })
  })
}

// 关闭当前页面
function viewPageDismiss(data) {
  let u = navigator.userAgent;
  let isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1;   // Android
  let isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);               // iOS
  if (isAndroid) {
    window.app.viewPageDismiss(data)
  } else if (isIOS) {
    var params = eval("("+data+")"); 
    iosBridgeCallHandler('viewPageDismiss', {'reload': params.reload}, (resp) => {
      console.log(resp);
    })
  } else {
    window.history.go(-1);
  } 
}

export {
  viewPageDismiss
};


