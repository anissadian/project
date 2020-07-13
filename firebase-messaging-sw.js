importScripts("https://www.gstatic.com/firebasejs/7.16.0/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/7.16.0/firebase-messaging.js");



var firebaseConfig = {
    apiKey: "AIzaSyCrjRRI5C1ZbCfY4E9lBfT41zhMgLsWwuA",
    authDomain: "project-1234554321.firebaseapp.com",
    databaseURL: "https://project-1234554321.firebaseio.com",
    projectId: "project-1234554321",
    storageBucket: "project-1234554321.appspot.com",
    messagingSenderId: "637967445990",
    appId: "1:637967445990:web:172766165590478fc2f027",
    measurementId: "G-L5WN0EPW1X"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  
  const messaging = firebase.messaging();
  messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = payload.data.title;
    const notificationOptions = {
      body: payload.data.body
    
    };
  
    return self.registration.showNotification(notificationTitle,
        notificationOptions);
  });
  