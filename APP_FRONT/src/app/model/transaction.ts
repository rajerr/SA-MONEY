import { User } from './user';
export interface Transaction {
    id:number;
    user:User;
    typeTransaction:string;
    dateEnvoie:string;
    montantEnvoye:string;
    frais:number;
    fraisDepot:number;
    fraisRetrait:number;
}