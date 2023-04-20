// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyBNESPuwUMNH6YWxdNKt8PbXNSUryYrwyg",
  authDomain: "sideline-f5195.firebaseapp.com",
  projectId: "sideline-f5195",
  storageBucket: "sideline-f5195.appspot.com",
  messagingSenderId: "582269631538",
  appId: "1:582269631538:web:61f55bfc3044f70570102b",
  measurementId: "G-PS5HW92LHK"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);