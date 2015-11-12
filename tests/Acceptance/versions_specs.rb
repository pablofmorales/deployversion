require 'airborne'

host = "http://deployversion:8000"

describe 'Versions Resource' do
  it 'should return a json response with the latests version of testProject' do
    get host + '/versions/latest/test'
    expect_json_keys('response', [:project, :version])
  end
end
