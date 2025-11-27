function numberNormalizer(number) {
  return number <= 9 ? `0${number}` : number;
}

function timeDifferenceFromNow(datetime) {
  const now = new Date()
  if (now > datetime) {
    return '00000000'
  }
  const result = new Date(datetime - now)

  const days = numberNormalizer(result.getUTCDate() - 1)
  const hours = numberNormalizer(result.getUTCHours())
  const minutes = numberNormalizer(result.getUTCMinutes())
  const seconds = numberNormalizer(result.getUTCSeconds())
  return `${days}${hours}${minutes}${seconds}`
}

function render(countdown, timeTo) {
  const splitedTimer = timeDifferenceFromNow(timeTo).split('')
  countdown.querySelectorAll('span').forEach((span, index) => {
    span.innerHTML = splitedTimer[index]
  })
}

(function countdownStart() {
  const countdowns = document.querySelectorAll('.countdown')
  countdowns.forEach(countdown => {
    const interval = setInterval(() => {
      const timeTo = new Date(+countdown.dataset.time)
      if (timeTo < new Date()) {
        clearInterval(interval)
      }
      render(countdown, timeTo)
    }, 1000)
  })
})()
