
let Coords;

export class MouseClass {

    MouseClass()
    {
        this.Coords = {};

        return this;

    }

    Move()
    {
        document.addEventListener('mousemove', (event) =>
        {
            console.log('log', event.pageX)
            this.Coords.X = event.clientX;
            this.Coords.Y =event.clientY;
        });
    }
}