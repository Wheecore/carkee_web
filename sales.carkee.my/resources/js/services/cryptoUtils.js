import CryptoJS from 'crypto-js';

const SECRET_KEY = '23ffd804bd8b10ca62e8';

export function encryptId(id) {
    const encrypted = CryptoJS.AES.encrypt(id.toString(), SECRET_KEY).toString();
    const safeEncrypted = encrypted.replace(/\//g, '_');
    return safeEncrypted;
}

export function decryptId(encryptedId) {
    const encryptedIdWithSlashes = encryptedId.replace(/_/g, '/');
    const bytes = CryptoJS.AES.decrypt(encryptedIdWithSlashes, SECRET_KEY);
    const decryptedId = bytes.toString(CryptoJS.enc.Utf8);
    return parseInt(decryptedId, 10);
}
