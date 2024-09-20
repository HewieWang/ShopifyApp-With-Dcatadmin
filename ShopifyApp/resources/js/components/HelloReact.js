import React, { useState } from 'react';
import ReactDOM from 'react-dom/client';
import { AppProvider, Page, Layout, TextContainer, Card, ResourceList, ResourceItem, TextStyle, Switch } from '@shopify/polaris';
import '@shopify/polaris/build/esm/styles.css'; // 引入 Polaris 的样式

// 功能项的数据
const items = [
  { id: 1, description: '功能1描述', enabled: false },
  { id: 2, description: '功能2描述', enabled: true },
  { id: 3, description: '功能3描述', enabled: false },
];

function App() {
  const [configItems, setConfigItems] = useState(items);

  // 切换开关状态
  const handleToggle = (id) => {
    setConfigItems((prevItems) =>
      prevItems.map((item) =>
        item.id === id ? { ...item, enabled: !item.enabled } : item
      )
    );
  };

  return (
    <AppProvider>
      <Page title="配置页面">
        <Layout>
          <Layout.Section>
            <Card sectioned>
              <ResourceList
                resourceName={{ singular: 'item', plural: 'items' }}
                items={configItems}
                renderItem={(item) => {
                  const { id, description, enabled } = item;
                  return (
                    <ResourceItem id={id}>
                      <TextContainer>
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                          <TextStyle variation="subdued">{description}</TextStyle>
                          <Switch
                            checked={enabled}
                            onChange={() => handleToggle(id)}
                          />
                        </div>
                      </TextContainer>
                    </ResourceItem>
                  );
                }}
              />
            </Card>
          </Layout.Section>
        </Layout>
      </Page>
    </AppProvider>
  );
}

// 渲染 App 组件
const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);
