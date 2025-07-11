// Validation d'email simple (regex standard)
export function isEmail(email) {
  return /^\S+@\S+\.\S+$/.test(email)
} 