
export default class AnimeJSTime 
{
    constructor(target, speed)
    {
        this.accumulateTime = -1;
        this.lastTime = -1;
        this.speed = speed;
        this.target = target;
        
    }

    TimeStart()
    {
        this.target.tick(this.TimeCurrent());
    }

    TimeUpdate(t) {
        if (this.accumulateTime === -1) {
            this.accumulateTime = t;
        } else {
            const deltaT = t - this.lastTime;
            this.accumulateTime += deltaT * this.speed;
        }

        this.lastTime = t;
    }

    SpeedUpdate(speed)
    {
        this.speed = speed;
    }

    TimeCurrent()
    {
        return this.accumulateTime;
    }

    TimeRamp(speed)
    {

        let Self = this;
        let Speed = speed ?? this.speed;

        let Ramp = (Speed) =>
        {
            Self.TimeUpdate(Speed);

            Self.target.tick(Self.TimeCurrent());

            requestAnimationFrame(Ramp);
        }

        requestAnimationFrame(Ramp);
    }
}