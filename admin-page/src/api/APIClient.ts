export interface IAPIClientRequestOptions {
    header?: HeadersInit;
}

class APIClient {
    private __baseURL: string;
    protected headers?: HeadersInit;
    protected mode?: RequestMode;

    constructor () {
        this.__baseURL = process.env.REACT_APP_BASE_URL! + process.env.REACT_APP_SPACESHIP_URL!;
        this.mode = 'no-cors';
    }

    protected get = <TResponse>(route:string) => new Promise<TResponse>((resolve, reject) => {
        fetch(this.__baseURL + route, {
            method: 'GET',
            headers: this.headers,
            mode: this.mode
        }).then( res => res.json())
            .then( data => resolve(data as TResponse))
            .catch( error => reject(error) );
    });

    protected post = <TResponse>(route:string, body: any,) => new Promise<TResponse>((resolve, reject) => {
        const data = JSON.stringify(body);
        fetch(this.__baseURL + route, {
            method: 'POST',
            body: data,
            headers: this.headers,
            mode: this.mode
        }).then( res => res.json())
            .then( data => resolve(data as TResponse))
            .catch( error => reject(error) );
    });

    protected patch = <TResponse>(route:string, body: any,) => new Promise<TResponse>((resolve, reject) => {
        const data = JSON.stringify(body);
        fetch(this.__baseURL + route, {
            method: 'PATCH',
            body: data,
            headers: this.headers,
            mode: this.mode
        }).then( res => res.json())
            .then( data => resolve(data as TResponse))
            .catch( error => reject(error) );
    });

    protected delete = <TResponse>(route:string) => new Promise<TResponse>((resolve, reject) => {
        fetch(this.__baseURL + route, {
            method: 'DELETE',
            headers: this.headers,
            mode: this.mode
        }).then( res => res.json())
            .then( data => resolve(data as TResponse))
            .catch( error => reject(error) );
    });
}

export default APIClient;