
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
  
  const getSeconds = () => (calculateDifference() % 60).toString();
  const getMinutes = () => (Math.floor((calculateDifference() / 60) % 60)).toString();
  const getHours   = () => (Math.floor((calculateDifference() / 60 / 60) % 24)).toString();
  const getDays    = () => (Math.floor((calculateDifference() / 60 / 60 / 24))).toString();

  function updateCounter() {
    const setCounterValue = (counter, newValue) => {
      let currentValue = counter.textContent;
      if (currentValue != newValue || !currentValue)
        counter.textContent = newValue;
    }
    setCounterValue(DaysCounter,    getDays());
    setCounterValue(HoursCounter,   getHours().length === 1 ? `0${getHours()}` : getHours());
    setCounterValue(MinutesCounter, getMinutes().length === 1 ? `0${getMinutes()}` : getMinutes());
    setCounterValue(SecondsCounter, getSeconds().length === 1 ? `0${getSeconds()}` : getSeconds());
  }
  
  updateCounter();

  setInterval(() => {
    console.log(`${getDays()} days | ${getHours()}:${getMinutes()}:${getSeconds()}`);
    updateCounter();
  }, 200)
}
