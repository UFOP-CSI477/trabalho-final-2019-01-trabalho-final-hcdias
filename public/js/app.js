const initServiceWorker = () => {
    if('serviceWorker' in navigator){
        navigator.serviceWorker
        .register('/sw.js')
        .then( ()=> (registration) => {
            firebase.messaging().useServiceWorker(registration);
        })
        .catch( ()=> console.log('service worker not registered'))
    }
}

const initFirebase = () => {
    var firebaseConfig = {
        messagingSenderId: "488962797554"
    };
  
    firebase.initializeApp(firebaseConfig);
}

  
const notification = async() => {
  try {
    const messaging = firebase.messaging();
    await messaging.requestPermission();
    const token = await messaging.getToken();
    return token;
  } catch (error) {
    console.error(error);
  }
}