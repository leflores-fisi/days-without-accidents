
const DaysCounter    = document.getElementById("days-counter");
const HoursCounter   = document.getElementById("hours-counter");
const MinutesCounter = document.getElementById("minutes-counter");
const SecondsCounter = document.getElementById("seconds-counter");

const lastAccidentTimestamp = document.getElementById("counter").dataset.timestamp;

if (lastAccidentTimestamp) {

  function calculateDifference() {
    let currentTimestamp = Math.floor(Date.now() / 1000);
    return currentTimestamp - lastAccidentTimestamp; // in seconds
  }
  
  const getSeconds = () => calculateDifference() % 60;
  const getMinutes = () => Math.floor((calculateDifference() / 60) % 60);
  const getHours   = () => Math.floor((calculateDifference() / 60 / 60) % 60);
  const getDays    = () => Math.floor((calculateDifference() / 60 / 60 / 24));

  function updateCounter() {
    const setCounterValue = (counter, newValue) => {
      let currentValue = counter.textContent;
      if (currentValue != newValue || !currentValue)
        counter.textContent = newValue;
    }
    setCounterValue(DaysCounter, getDays());
    setCounterValue(HoursCounter, getHours());
    setCounterValue(MinutesCounter, getMinutes());
    setCounterValue(SecondsCounter, getSeconds());
  }
  
  updateCounter();

  setInterval(() => {
    console.log(`${getDays()} days | ${getHours()}:${getMinutes()}:${getSeconds()}`);
    updateCounter();
  }, 200)
}
