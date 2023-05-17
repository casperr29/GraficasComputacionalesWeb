window.addEventListener("load", function() {
    const clock = document.getElementById("time");
    let time = -1, intervalId;
    function incrementTime() {
      time++;
      clock.textContent =
        ("0" + Math.trunc(time / 60)).slice(-2) +
        ":" + ("0" + (time % 60)).slice(-2);
    }
    incrementTime();
    intervalId = setInterval(incrementTime, 1000);
  }); 

/*   function stopWatch() {
    let time, intervalId;
    let stopBtn = document.getElementById("stopBtn");
  
     function strtWatch() {
      time = -1;
      incrementTime();
      intervalId = setInterval(incrementTime, 1000);        
      stopBtn.disabled = false;
    }
   strtWatch();
  
    stopBtn.addEventListener("click", function() {
      clearInterval(intervalId);        
      stopBtn.disabled = true;
    });
  
    function incrementTime() {
      time++;
      document.getElementById("time").textContent =
        ("0" + Math.trunc(time / 60)).slice(-2) +
        ":" + ("0" + (time % 60)).slice(-2);
    }
  } */