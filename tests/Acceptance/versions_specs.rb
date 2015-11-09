require 'airborne'

host = "http://localhost:8080"

describe 'Versions Resource' do
  it 'should return a json response with the latests version of testProject' do
    get host + '/versions/latest/testProject'

    expect_json({
        :response => [
            {
                :project => 'testProject',
                :version => '1.15.22'
            }
        ]
    })
  end
end
