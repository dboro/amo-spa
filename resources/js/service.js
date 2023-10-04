const url = '/api'

export async function getLeads() {
    const response = await axios.get(`${url}/leads`)
    return response.data.data
}

export async function getLogs() {
    const response = await axios.get(`${url}/logs`)
    return response.data.data
}

export async function addContact(data) {
    const response = await axios.post(`${url}/contacts`, data)
    return response.data.data
}
