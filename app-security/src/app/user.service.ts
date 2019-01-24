import { Injectable } from '@angular/core';
import { HttpClient, HttpClientModule, HttpHeaders } from '@angular/common/http';
import { User } from './user';
import { Observable, of, Subscription, Subject } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';

const baseUrl : string = "http://localhost/dev/a3/tp-securite/rest/index.php?" ;
const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type': 'application/json',
  }),
  withCredentials: true,
};

@Injectable({
  providedIn: 'root',
})

export class UserService {
  connectedUser: User;

  constructor(
    private http: HttpClient,
  ) 
  { 
    this.connectedUser = new User();
  }

  addUser(user : User) : Observable<any> {
    const url = `${baseUrl}add-user`;
    let parameters = {
      "email": user.email,
      "pwd": user.password,
      "profil": user.profilId,
    }
    return this.http.post<User>(url, parameters, httpOptions).pipe(
      tap((user) => console.log(`added user`)),
      map((response) => {
        return response;
      }),
      catchError(this.handleError<User>('add todo'))
    );
  }

  connectUser(user: User): Observable<any>{
    const url = `${baseUrl}connect-user`;
    let parameters = {
      "email": user.email,
      "pwd": user.password,
    }
    return this.http.post<User>(url, parameters, httpOptions).pipe(
      tap((user) => console.log(`connect user`)),
      map((userId) => {
        return userId;
      }),
      catchError(this.handleError<User>('connect user'))
    );
  }

  deconnectUser(): Observable<any>{
    const url = `${baseUrl}deconnect-user`;
    let parameters = {
      "id" : this.connectedUser.id
    }
    return this.http.post(url, parameters, httpOptions).pipe(
      tap((noParameter) => console.log(`Disconnect User`)),
      catchError(this.handleError('disconnect user'))
    );
  }

  async getUserList(): Promise<any> {
    const url = `${baseUrl}get-user-list`;
    var isConnected = await this.isSessionOpen();
    let parameters = {
      'id': this.connectedUser.id
    }
    var ret;
    if(isConnected){
      ret = this.http.post(url, parameters, httpOptions).pipe(
        tap((noParameter) => console.log(`Get user list`)),
        map((userList) => {
          console.log(userList)
          return userList;
        }),
        catchError(this.handleError('get users'))
      ).toPromise();
    }else{
      console.log("need to connect");
    }
    return ret;
  }

  /**
   * If a cookie is record set the this.connectedUser.id with the cookie
   * Check if the session is open, if it return true
   */
  async isSessionOpen(): Promise<any> {
    const url = `${baseUrl}is-session-open`;
    let idConnected = await this.idUserConnected();
    if(idConnected.hasOwnProperty('error')){
      console.log(idConnected);
    }else{
      console.log('id user opened session', idConnected);
      this.connectedUser.id = idConnected
    }
    let parameters = {
      'id': this.connectedUser.id
    }
    return this.http.post(url, parameters, httpOptions).pipe(
      tap((user) => console.log(`ìs session open`)),
      catchError(this.handleError('is session open'))
    ).toPromise();
  }

  /**
   * Check if there is a cookie 'currentUser'
   */
  async idUserConnected(): Promise<any> {
    const url = `${baseUrl}is-user-connected`;
    return this.http.get(url, httpOptions).pipe(
      tap((user) => console.log('is user connected')),
      catchError(this.handleError('is user connected'))
    ).toPromise();
  }

    /**
   * Handle Http operation that failed.
   * Let the app continue.
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
  
      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead
  
      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

  checkMail(email): boolean{
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }

  checkPwd(pwd, pwdCheck): boolean{
    var result = false;
    if (pwd === pwdCheck){
        result = true;
    }
    return result;
  }

  checkProfil(profil): boolean{
    var result = false;
    if (profil != "" && profil != 0 ){
        result = true;
    }
    return result;
  }
}
