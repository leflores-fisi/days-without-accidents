
const Counter = document.getElementById("counter");
const lastAccidentTimestamp = Counter.dataset.timestamp;

if (lastAccidentTimestamp) {

  function calculateDifference() {
    let currentTimestamp = Math.floor(Date.now() / 1000);
    return currentTimestamp - lastAccidentTimestamp; // in seconds
  }
  
  function getSeconds () {
    return calculateDifference() % 60;
  }
  function getMinutes () {
    return Math.floor((calculateDifference() / 60) % 60);
  }
  function getHours () {
    return Math.floor((calculateDifference() / 60 / 60) % 60);
  }
  function getDays () {
    return Math.floor((calculateDifference() / 60 / 60 / 24));
  }
  
  Counter.textContent = getDays();
  
  setInterval(() => {
    console.log(`${getDays()} |  ${getHours()} : ${getMinutes()} : ${getSeconds()}`);
    Counter.textContent = getDays();
  }, 200)
} 
